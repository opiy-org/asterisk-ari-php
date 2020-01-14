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
use InvalidArgumentException;
use JsonException;
use Monolog\Logger;
use NgVoice\AriClient\Client\Rest\Resource\Applications;
use NgVoice\AriClient\Client\Rest\Settings as RestClientSettings;
use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use NgVoice\AriClient\Helper;
use NgVoice\AriClient\StasisApplicationInterface;
use Oktavlachs\DataMappingService\Collection\SourceNamingConventions;
use Oktavlachs\DataMappingService\DataMappingService;
use ReflectionFunction;
use ReflectionMethod;
use ReflectionObject;
use Throwable;

/**
 * Implementation of a basic web socket client that avoids duplicated
 * code for web socket event handler logic.
 *
 * @package NgVoice\AriClient\WebSocket
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
abstract class AbstractWebSocketClient implements WebSocketClientInterface
{
    protected Logger $logger;

    protected DataMappingService $dataMappingService;

    protected StasisApplicationInterface $myApp;

    private Applications $ariApplicationsClient;

    private Closure $errorHandler;

    /**
     * AbstractWebSocketClient constructor.
     *
     * @param Settings $webSocketClientSettings Configurable settings for this client
     * @param StasisApplicationInterface $myApp Your Stasis application
     * @param Applications $ariApplicationsClient ARI applications REST client
     * @param Logger|null $logger The logger service for this client
     * @param DataMappingService|null $dataMappingService The service to map JSON
     * onto objects with
     */
    public function __construct(
        Settings $webSocketClientSettings,
        StasisApplicationInterface $myApp,
        Applications $ariApplicationsClient = null,
        Logger $logger = null,
        DataMappingService $dataMappingService = null
    ) {
        $this->myApp = $myApp;
        $this->initializeErrorHandler($webSocketClientSettings->getErrorHandler());

        if ($ariApplicationsClient === null) {
            $ariApplicationsClient = new Applications(
                new RestClientSettings(
                    $webSocketClientSettings->getUser(),
                    $webSocketClientSettings->getPassword()
                )
            );
        }

        $this->ariApplicationsClient = $ariApplicationsClient;

        if ($logger === null) {
            $logger = Helper::initLogger(static::class);
        }

        $this->logger = $logger;

        if ($dataMappingService === null) {
            $dataMappingService = new DataMappingService(
                SourceNamingConventions::LOWER_SNAKE_CASE
            );
            $dataMappingService->setIsThrowingInvalidArgumentExceptionOnValidationError(
                true
            );
        }

        $this->dataMappingService = $dataMappingService;
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
            $this->extractPublicFunctionNames($myAppAsReflectionObject);

        // Only use functions, that are named after a valid Asterisk message type
        $allowedMessages = $this
            ->filterAsteriskEventMessageFunctions($myAppPublicClassMethodNames);

        $applicationName = $myAppAsReflectionObject->getShortName();

        $this->ariApplicationsClient->filter($applicationName, $allowedMessages);

        $this->logger->debug(
            'Successfully set event filter for app in Asterisk',
            [__FUNCTION__]
        );

        $this->logger->info(
            sprintf(
                "Your Stasis app '%s' listens for the following events: '%s'",
                $applicationName,
                (string) print_r($allowedMessages, true)
            )
        );
    }

    /**
     * Define what happens in case the web socket
     * client receives a new messsage.
     *
     * @param string $message The message to handle
     *
     * @noinspection PhpRedundantCatchClauseInspection We know that
     * a JsonException can be thrown here because we explicitly set
     * the flag.
     */
    public function onMessageHandlerLogic(string $message): void
    {
        try {
            $jsonAsArray = json_decode($message, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            $errorMessage = sprintf(
                "JSON decode ARI event failed. Error message -> '%s' | JSON -> '%s'",
                $e->getMessage(),
                $message
            );

            $this->logger->error($errorMessage, [__FUNCTION__]);

            return;
        }

        $ariEventType = $jsonAsArray['type'];
        $eventClassNamespace =
            "NgVoice\\AriClient\\Model\\Message\\Event\\" . $ariEventType;

        $messageObject = new $eventClassNamespace();

        try {
            $this->dataMappingService->mapArrayOntoObject($jsonAsArray, $messageObject);
        } catch (InvalidArgumentException $invalidArgumentException) {
            $errorMessage = sprintf(
                'Mapping incoming JSON from ARI web socket server '
                . "onto object '%s' failed | Error message: '%s'",
                $eventClassNamespace,
                $invalidArgumentException->getMessage()
            );

            ($this->errorHandler)(
                $ariEventType,
                new InvalidArgumentException(
                    $errorMessage,
                    $invalidArgumentException->getCode(),
                    $invalidArgumentException
                )
            );

            return;
        }

        $functionName = self::ARI_EVENT_HANDLER_FUNCTION_PREFIX . $ariEventType;

        try {
            $this->myApp->$functionName($messageObject);
        } catch (Throwable $throwable) {
            ($this->errorHandler)($ariEventType, $throwable);
            return;
        }

        $this->logger->debug(
            "Event successfully handled by your app: '{$message}'",
            [__FUNCTION__]
        );
    }

    /**
     * Create the URI for a REST request to the ARI applications resource.
     *
     * The URI represents the initial request sent to the ARI, to register
     * a web socket client.
     *
     * @param Settings $webSocketClientSettings The settings for a web socket client
     * @param StasisApplicationInterface $stasisApplication The event handling Stasis app
     * @param bool $subscribeAll If the web socket should subscribe to all available
     * ARI events, instead of specific ones for a single application.
     *
     * @return string The URI for the web socket client
     */
    protected function createUri(
        Settings $webSocketClientSettings,
        StasisApplicationInterface $stasisApplication,
        bool $subscribeAll
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

        $subscribeAllParameter = $subscribeAll ? 'true' : 'false';

        $uri = sprintf(
            '%s/events?api_key=%s:%s&app=%s&subscribeAll=%s',
            $wsUrl,
            $webSocketClientSettings->getUser(),
            $webSocketClientSettings->getPassword(),
            (new ReflectionObject($stasisApplication))->getShortName(),
            $subscribeAllParameter
        );

        $this->logger->debug("URI to asterisk: '{$uri}'");

        return $uri;
    }

    /**
     * Extract the available public function names from a Stasis application.
     *
     * @param ReflectionObject $myAppAsReflectionObject The Stasis app to extract the
     * public function names from as a ReflectionObject
     *
     * @return array<int, string>
     */
    private function extractPublicFunctionNames(
        ReflectionObject $myAppAsReflectionObject
    ): array {
        $publicReflectionMethods = $myAppAsReflectionObject->getMethods(
            ReflectionMethod::IS_PUBLIC & ~ReflectionMethod::IS_STATIC
        );

        $publicFunctionNames = [];

        foreach ($publicReflectionMethods as $method) {
            $publicFunctionNames[] = $method->getName();
        }

        return $publicFunctionNames;
    }

    /**
     * Go through a list of available public class function names and
     * filter the functions with the reserved ARI event handler function prefix.
     *
     * @param string[] $myAppPublicClassFunctionNames Public function names of a class
     *
     * @return string[]
     */
    private function filterAsteriskEventMessageFunctions(
        array $myAppPublicClassFunctionNames
    ): array {
        /** @var string[] $ariEventFunctionNames */
        $ariEventFunctionNames = [];

        foreach ($myAppPublicClassFunctionNames as $publicFunctionName) {
            // Check for correct prefix syntax on incoming ARI events
            if (
                strpos(
                    $publicFunctionName,
                    self::ARI_EVENT_HANDLER_FUNCTION_PREFIX
                ) === 0
            ) {
                $publicFunctionName = (string) substr(
                    $publicFunctionName,
                    strlen(self::ARI_EVENT_HANDLER_FUNCTION_PREFIX)
                );

                if (
                    class_exists(
                        "NgVoice\\AriClient\\Model\\Message\\Event\\"
                        . $publicFunctionName
                    )
                ) {
                    $ariEventFunctionNames[] = $publicFunctionName;
                }
            }
        }

        return $ariEventFunctionNames;
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
            $errorHandler = static function (string $messageType, Throwable $throwable) {
                $errorMessage = sprintf(
                    "Error while handling message '%s' -------> '%s'",
                    $messageType,
                    $throwable->getMessage()
                );

                $this->logger->error($errorMessage);
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
