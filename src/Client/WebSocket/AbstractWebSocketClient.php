<?php

/**
 * @copyright 2020 ng-voice GmbH
 *
 * @noinspection UnknownInspectionInspection Plugin [EA] does not
 * recognize the noinspection annotation of PhpStorm
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Client\WebSocket;

use Closure;
use Throwable;
use JsonException;
use ReflectionMethod;
use ReflectionObject;
use ReflectionFunction;
use Psr\Log\LoggerInterface;
use InvalidArgumentException;
use NgVoice\AriClient\Helper;
use NgVoice\AriClient\StasisApplicationInterface;
use Oktavlachs\DataMappingService\DataMappingService;
use NgVoice\AriClient\Client\Rest\Resource\Applications;
use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use NgVoice\AriClient\Client\Rest\Settings as RestClientSettings;
use Oktavlachs\DataMappingService\Collection\SourceNamingConventions;
use Oktavlachs\DataMappingService\Exception\DataMappingServiceException;

/**
 * Implementation of a basic web socket client that avoids duplicated
 * code for web socket event handler logic.
 *
 * @package NgVoice\AriClient\Client\WebSocket
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
abstract class AbstractWebSocketClient implements WebSocketClientInterface
{
    protected bool $isInDebugMode;

    protected LoggerInterface $logger;

    protected DataMappingService $dataMappingService;

    protected StasisApplicationInterface $myApp;

    private Applications $ariApplicationsClient;

    private Closure $errorHandler;

    /**
     * AbstractWebSocketClient constructor.
     *
     * @param Settings $webSocketClientSettings Configurable settings for this client
     * @param StasisApplicationInterface $myApp Your Stasis application
     */
    public function __construct(
        Settings $webSocketClientSettings,
        StasisApplicationInterface $myApp
    ) {
        $this->myApp = $myApp;

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
                    $webSocketClientSettings->getPassword()
                )
            );
        }

        $this->ariApplicationsClient = $ariApplicationsClient;

        $this->dataMappingService = new DataMappingService(
            SourceNamingConventions::LOWER_SNAKE_CASE
        );

        $this->dataMappingService->setIsUsingTargetObjectSetters(false);

        $this->isInDebugMode = $webSocketClientSettings->isInDebugMode();
    }

    /**
     * The logic to execute on a successful connection to a web socket server.
     *
     * @throws AsteriskRestInterfaceException In case the event filter request fails.
     */
    public function onConnectionHandlerLogic(): void
    {
        $myAppAsReflectionObject = new ReflectionObject($this->myApp);

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
            (string) print_r($allowedEvents, true)
        );

        $this->logger->info($infoMessage);
    }

    /**
     * Define what happens in case the web socket
     * client receives a new message.
     *
     * @param string $ariEventAsJson The Asterisk REST Interface event as a JSON string
     *
     * @noinspection PhpRedundantCatchClauseInspection We know that
     * a JsonException can be thrown here because we explicitly set
     * the flag.
     */
    public function onMessageHandlerLogic(string $ariEventAsJson): void
    {
        try {
            $ariEventAsArray =
                json_decode($ariEventAsJson, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            $errorMessage = sprintf(
                "Decoding JSON ARI event failed. Error message -> '%s' | JSON -> '%s'",
                $e->getMessage(),
                $ariEventAsJson
            );

            $this->logger->error($errorMessage, [__FUNCTION__]);

            return;
        }

        $ariEventType = $ariEventAsArray['type'];
        $ariEventNamespace =
            "NgVoice\\AriClient\\Model\\Message\\Event\\" . $ariEventType;

        $ariEventAsObject = new $ariEventNamespace();

        try {
            $this
                ->dataMappingService
                ->mapArrayOntoObject($ariEventAsArray, $ariEventAsObject);
        } catch (DataMappingServiceException $dataMappingServiceException) {
            $errorMessage = sprintf(
                'Mapping incoming JSON from ARI web socket server '
                . "onto object '%s' failed | Error message: '%s'",
                $ariEventNamespace,
                $dataMappingServiceException->getMessage()
            );

            ($this->errorHandler)(
                $ariEventType,
                new InvalidArgumentException(
                    $errorMessage,
                    $dataMappingServiceException->getCode(),
                    $dataMappingServiceException
                )
            );

            return;
        }

        try {
            $this
                ->myApp
                ->{self::ARI_EVENT_HANDLER_METHOD_PREFIX . $ariEventType}(
                    $ariEventAsObject
                );
        } catch (Throwable $throwable) {
            ($this->errorHandler)($ariEventType, $throwable);
            return;
        }

        if ($this->isInDebugMode) {
            $this->logger->debug(
                sprintf(
                    "Your app successfully handled the ARI Event -> '%s'",
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
            (string) $webSocketClientSettings->getPort(),
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
    private function extractHandledAsteriskEvents(
        array $myAppPublicMethodNames
    ): array {
        /** @var array<int, string> $handledAriEvents */
        $handledAriEvents = [];
        $eventHandlerMethodPrefixStringLength =
            strlen(self::ARI_EVENT_HANDLER_METHOD_PREFIX);

        foreach ($myAppPublicMethodNames as $publicMethodName) {
            // Check for correct prefix syntax on incoming ARI events
            if (strpos($publicMethodName, self::ARI_EVENT_HANDLER_METHOD_PREFIX) === 0) {
                $eventName = (string) substr(
                    $publicMethodName,
                    $eventHandlerMethodPrefixStringLength
                );

                if (
                    class_exists(
                        "NgVoice\\AriClient\\Model\\Message\\Event\\" . $eventName
                    )
                ) {
                    $handledAriEvents[] = $eventName;
                } else {
                    $errorMessage = sprintf(
                        "The method '%s' in your Stasis application class '%s' "
                        . 'has the correct ARI event handler method prefix but '
                        . 'does not specify a valid ARI event name suffix.',
                        $publicMethodName,
                        get_class($this->myApp)
                    );

                    throw new InvalidArgumentException($errorMessage);
                }
            }
        }

        return $handledAriEvents;
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
            $errorLogger = $this->logger;

            $errorHandler = static function (
                string $messageType,
                Throwable $throwable
            ) use ($errorLogger) {
                $errorMessage = sprintf(
                    "Error while handling message '%s' -------> '%s'",
                    $messageType,
                    $throwable->getMessage()
                );

                $errorLogger->error($errorMessage);
            };
        } else {
            /**
             * @noinspection PhpUnhandledExceptionInspection By declaring
             * $errorHandler as a Closure, this exception is never thrown.
             */
            $parameters = (new ReflectionFunction($errorHandler))->getParameters();

            if (
                !isset($parameters[0], $parameters[1])
                || ($parameters[0]->getName() !== 'messageType')
                || (($typeOne = $parameters[0]->getType()) === null)
                || ($typeOne->getName() !== 'string')
                || ($parameters[1]->getName() !== 'throwable')
                || (($typeTwo = $parameters[1]->getType()) === null)
                || ($typeTwo->getName() !== Throwable::class)
            ) {
                throw new InvalidArgumentException(
                    "The provided error handlers signature must start with 'static "
                    . "function (string \$messageType, Throwable \$throwable) ...'"
                );
            }
        }

        $this->errorHandler = $errorHandler;
    }
}
