<?php

/**
 * @copyright 2020 ng-voice GmbH
 *
 * @noinspection UnknownInspectionInspection Plugin [EA] does not
 * recognize the noinspection annotation of PhpStorm
 */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Client\WebSocket;

use Closure;
use CuyZ\Valinor\Mapper\Source\Source;
use CuyZ\Valinor\Mapper\TreeMapper;
use CuyZ\Valinor\MapperBuilder;
use InvalidArgumentException;
use JsonException;
use OpiyOrg\AriClient\Client\Rest\Resource\Applications;
use OpiyOrg\AriClient\Client\Rest\Settings as RestClientSettings;
use OpiyOrg\AriClient\Exception\AsteriskRestInterfaceException;
use OpiyOrg\AriClient\Helper;
use OpiyOrg\AriClient\StasisApplicationInterface;
use Psr\Log\LoggerInterface;
use ReflectionFunction;
use ReflectionMethod;
use ReflectionObject;
use Throwable;

/**
 * Implementation of a basic web socket client that avoids duplicated
 * code for web socket event handler logic.
 *
 * @package OpiyOrg\AriClient\Client\WebSocket
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
abstract class AbstractWebSocketClient implements WebSocketClientInterface
{
    protected bool $isInDebugMode;

    protected LoggerInterface $logger;

    protected StasisApplicationInterface $stasisApplication;

    private TreeMapper $dataMappingService;

    private Closure $errorHandler;

    private Applications $ariApplicationsClient;

    /**
     * AbstractWebSocketClient constructor.
     *
     * @param Settings $webSocketClientSettings Configurable settings for this client
     * @param StasisApplicationInterface $stasisApplication A Stasis application
     * class containing your event handler logic
     */
    public function __construct(
        Settings $webSocketClientSettings,
        StasisApplicationInterface $stasisApplication
    ) {
        $this->stasisApplication = $stasisApplication;

        $logger = $webSocketClientSettings->getLoggerInterface();

        if ($logger === null) {
            $logger = Helper::initLogger(static::class);
        }

        $this->logger = $logger;

        $this->initializeErrorHandler($webSocketClientSettings->getErrorHandler());

        $ariApplicationsClient = $webSocketClientSettings->getAriApplicationsClient();

        if ($ariApplicationsClient === null) {
            $ariApplicationsClient = new Applications(
                new RestClientSettings(
                    $webSocketClientSettings->getUser(),
                    $webSocketClientSettings->getPassword(),
                    $webSocketClientSettings->getHost(),
                    $webSocketClientSettings->getPort()
                )
            );
        }

        $this->dataMappingService = (new MapperBuilder())
            ->enableFlexibleCasting()
            ->allowSuperfluousKeys()
            ->allowPermissiveTypes()
            ->mapper();

        $this->ariApplicationsClient = $ariApplicationsClient;

        $this->isInDebugMode = $webSocketClientSettings->isInDebugMode();
    }

    /**
     * Initialize the error handler for this AbstractWebSocketClient.
     *
     * @param Closure|null $errorHandler The error handler to initialize
     *
     * @return void
     *
     * @noinspection PhpDocMissingThrowsInspection The ReflectionException is never
     * thrown when getting an instance of the $errorHandler Closure.
     */
    private function initializeErrorHandler(?Closure $errorHandler): void
    {
        if ($errorHandler === null) {
            $this->errorHandler = function (string $context, Throwable $throwable) {
                $errorMessage = sprintf(
                    "Error while handling '%s' -------> '%s'",
                    $context,
                    $throwable->getMessage()
                );

                $this->logger->error($errorMessage);
            };

            return;
        }

        /**
         * @noinspection PhpUnhandledExceptionInspection Because
         * $errorHandler is a Closure, this exception is never thrown.
         */
        $parameters = (new ReflectionFunction($errorHandler))->getParameters();

        if (
            !isset($parameters[0], $parameters[1])
            || ($parameters[0]->getName() !== 'context')
            || (($typeOne = $parameters[0]->getType()) === null)
            || ($typeOne->getName() !== 'string')
            || ($parameters[1]->getName() !== 'throwable')
            || (($typeTwo = $parameters[1]->getType()) === null)
            || ($typeTwo->getName() !== Throwable::class)
        ) {
            throw new InvalidArgumentException(
                'The provided error handlers signature must start with '
                . "'function (string \$context, Throwable \$throwable) ...'"
            );
        }

        $this->errorHandler = $errorHandler;
    }

    /**
     * The logic to execute on a successful connection to a web socket server.
     *
     * @throws AsteriskRestInterfaceException In case the event filter request fails.
     */
    public function onConnectionHandlerLogic(): void
    {
        $myAppAsReflectionObject = new ReflectionObject($this->stasisApplication);

        $myAppPublicClassMethodNames =
            $this->extractPublicMethodNames($myAppAsReflectionObject);

        // Only use methods, that are named after a valid Asterisk event type
        $allowedEvents =
            $this->extractHandledAsteriskEvents($myAppPublicClassMethodNames);

        $applicationName = $myAppAsReflectionObject->getShortName();

        /**
         * Tell Asterisk to only send events that are actually handled by the
         * given StasisApplicationInterface. This boosts the performance a lot.
         * @see https://blogs.asterisk.org/2019/02/27/filtering-event-types-ari/
         */
        $this->ariApplicationsClient->filter($applicationName, $allowedEvents);

        if ($this->isInDebugMode) {
            $this->logger->debug(
                'Successfully set event filter for app in Asterisk',
                [__FUNCTION__]
            );
        }

        $infoMessage = sprintf(
            "Your Stasis app '%s' listens for the following events: '%s'",
            $applicationName,
            print_r($allowedEvents, true)
        );

        $this->logger->info($infoMessage);
    }

    /**
     * Extract the available public method names from a Stasis application.
     *
     * @param ReflectionObject $myAppAsReflectionObject The Stasis app to extract
     * the public method names from
     *
     * @return array<int, string>
     */
    private function extractPublicMethodNames(
        ReflectionObject $myAppAsReflectionObject
    ): array {
        $publicReflectionMethods = $myAppAsReflectionObject->getMethods(
            ReflectionMethod::IS_PUBLIC & ~ReflectionMethod::IS_STATIC
        );

        $publicMethodNames = [];

        foreach ($publicReflectionMethods as $publicMethod) {
            $publicMethodNames[] = $publicMethod->getName();
        }

        return $publicMethodNames;
    }

    /**
     * Collect the names of Asterisk events the Stasis application class handles.
     *
     * Go through a list of public method names and filter the method names
     * starting with the reserved ARI event handler method prefix.
     * Extract the event name from the method name and add it to a result list.
     *
     * @param array<int, string> $myAppPublicMethodNames Names of the
     * public methods of a given StasisApplicationInterface
     *
     * @return array<int, string> The list of Asterisk events, handled by
     * the given StasisApplicationInterface
     */
    private function extractHandledAsteriskEvents(array $myAppPublicMethodNames): array
    {
        /** @var array<int, string> $handledAriEvents */
        $handledAriEvents = [];
        $eventHandlerMethodPrefixLength = strlen(self::ARI_EVENT_HANDLER_METHOD_PREFIX);

        foreach ($myAppPublicMethodNames as $methodName) {
            // Check for correct prefix syntax on incoming ARI events
            if (!str_starts_with($methodName, self::ARI_EVENT_HANDLER_METHOD_PREFIX)) {
                // Allow any public methods without the prefix
                continue;
            }

            $eventName = substr($methodName, $eventHandlerMethodPrefixLength);

            if (
                !class_exists("OpiyOrg\\AriClient\\Model\\Message\\Event\\" . $eventName)
            ) {
                $errorMessage = sprintf(
                    "The method '%s' in your Stasis application class '%s' "
                    . 'has the correct ARI event handler method prefix but '
                    . 'does not specify a valid ARI event name suffix.',
                    $methodName,
                    get_class($this->stasisApplication)
                );

                throw new InvalidArgumentException($errorMessage);
            }

            $handledAriEvents[] = $eventName;
        }

        return $handledAriEvents;
    }

    /**
     * Define what happens in case the web socket
     * client receives a new message.
     *
     * @param string $ariEventAsJson The Asterisk REST Interface event as a JSON string
     *
     */
    public function onMessageHandlerLogic(string $ariEventAsJson): void
    {
        try {
            $ariEventAsArray =
                json_decode($ariEventAsJson, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $jsonException) {
            $context = sprintf(
                "Decoding JSON from ARI failed. Error message -> '%s' | JSON -> '%s'",
                $jsonException->getMessage(),
                $ariEventAsJson
            );

            ($this->errorHandler)($context, $jsonException);

            return;
        }

        $ariEventType = $ariEventAsArray['type'];
        $ariEventNamespace =
            "OpiyOrg\\AriClient\\Model\\Message\\Event\\" . $ariEventType;

        $ariEventAsObject = new $ariEventNamespace();

        try {
            $ariEventAsObject = $this->dataMappingService
                ->map(
                    $ariEventAsObject::class,
                    Source::array($ariEventAsArray)->camelCaseKeys()
                );
        } catch (Throwable $exception) {
            $context = sprintf(
                'Mapping incoming JSON from ARI web socket server '
                . "onto object '%s' failed | Error message: '%s'",
                $ariEventNamespace,
                $exception->getMessage()
            );

            ($this->errorHandler)($context, $exception);

            return;
        }

        // Call the event handler method in the provided Stasis application class
        try {
            $this
                ->stasisApplication
                ->{self::ARI_EVENT_HANDLER_METHOD_PREFIX . $ariEventType}(
                    $ariEventAsObject
                );
        } catch (Throwable $throwable) {
            $errorMessage = sprintf(
                "Error in Stasis application '%s' while handling ARI event: '%s'",
                get_class($this->stasisApplication),
                $ariEventType
            );

            ($this->errorHandler)($errorMessage, $throwable);
            return;
        }

        if ($this->isInDebugMode) {
            $this->logger->debug(
                sprintf(
                    "Your app successfully handled the ARI event -> '%s'",
                    $ariEventAsJson
                ),
                [__FUNCTION__]
            );
        }
    }

    /**
     * Create the URI for a REST request to the ARI applications resource.
     *
     * The URI represents the initial request sent to the ARI, to register
     * a web socket client.
     *
     * @param Settings $webSocketClientSettings The settings for a web socket client
     * @param StasisApplicationInterface $stasisApplication The event handling Stasis app
     *
     * @return string The URI for the web socket client
     */
    protected function createUri(
        Settings $webSocketClientSettings,
        StasisApplicationInterface $stasisApplication
    ): string {
        /*
         * Within this library you should only either subscribe to one or all running
         * StasisApps on Asterisk.
         * It is a good idea - regarding separation of concerns - to have a worker
         * process for each application you are running, so your code doesn't get messy.
         */

        // Initialize the WebSocket
        $wsType = $webSocketClientSettings->isWssEnabled() ? 'wss' : 'ws';

        $wsUrl = sprintf(
            '%s://%s:%s%s',
            $wsType,
            $webSocketClientSettings->getHost(),
            $webSocketClientSettings->getPort(),
            $webSocketClientSettings->getRootUri()
        );

        $subscribeAllParameter =
            $webSocketClientSettings->isSubscribeAll() ? 'true' : 'false';

        $uri = sprintf(
            '%s/events?api_key=%s:%s&app=%s&subscribeAll=%s',
            $wsUrl,
            $webSocketClientSettings->getUser(),
            $webSocketClientSettings->getPassword(),
            (new ReflectionObject($stasisApplication))->getShortName(),
            $subscribeAllParameter
        );

        if ($this->isInDebugMode) {
            $this->logger->debug(sprintf("URI to asterisk: '%s'", $uri), [__FUNCTION__]);
        }

        return $uri;
    }
}
