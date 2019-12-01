<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\WebSocketClient;

use JsonException;
use JsonMapper;
use JsonMapper_Exception;
use Monolog\Logger;
use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use NgVoice\AriClient\Helper;
use NgVoice\AriClient\RestClient\ResourceClient\Applications;
use NgVoice\AriClient\RestClient\Settings as RestClientSettings;
use NgVoice\AriClient\StasisApplicationInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

/**
 * Implementation of a basic web socket client that avoids duplicated
 * code for web socket event handler logic.
 *
 * @package NgVoice\AriClient\WebSocketClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
abstract class AbstractWebSocketClient implements WebSocketClientInterface
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var JsonMapper
     */
    protected $jsonMapper;

    /**
     * @var StasisApplicationInterface
     */
    protected $myApp;

    /**
     * @var Applications
     */
    private $ariApplicationsClient;

    /**
     * AbstractWebSocketClient constructor.
     *
     * @param Settings $webSocketClientSettings The settings for this web socket client
     * @param StasisApplicationInterface $myApp Your Stasis application
     * @param Applications $ariApplicationsClient ARI applications REST client
     * @param Logger|null $logger The logger for this web socket client
     * @param JsonMapper|null $jsonMapper The JSON mapper for this web socket client
     */
    public function __construct(
        Settings $webSocketClientSettings,
        StasisApplicationInterface $myApp,
        Applications $ariApplicationsClient = null,
        Logger $logger = null,
        JsonMapper $jsonMapper = null
    ) {
        $this->myApp = $myApp;

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

        if ($jsonMapper === null) {
            $jsonMapper = new JsonMapper();
        }

        $this->jsonMapper = $jsonMapper;
    }

    /**
     * The logic to execute on a successful connection to a web socket server.
     *
     * @throws AsteriskRestInterfaceException In case the event filter request fails.
     */
    public function onConnectionHandlerLogic()
    {
        $myAppPublicClassMethodNames = $this->extractPublicClassMethodNames($this->myApp);

        // Only use functions, that are named after a valid Asterisk message type
        $allowedMessages = $this
            ->filterAsteriskEventMessageFunctions($myAppPublicClassMethodNames);

        $applicationName = Helper::getShortClassName($this->myApp);

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
     */
    public function onMessageHandlerLogic(string $message): void
    {
        try {
            $decodedJson = json_decode(
                $message,
                false,
                512,
                JSON_THROW_ON_ERROR
            );
        } catch (JsonException $e) {
            $this->logger->error(sprintf("JSON decode failed: '%s'", $e->getMessage()));
            exit(1);
        }

        $ariEventType = $decodedJson->type;

        $eventPath = "NgVoice\\AriClient\\Models\\Message\\" . $ariEventType;

        try {
            $mappedEventObject = $this
                ->jsonMapper
                ->map($decodedJson, new $eventPath());
        } catch (JsonMapper_Exception $jsonMapper_Exception) {
            $this->logger->error(
                sprintf(
                    'Mapping incoming JSON from ARI web socket server '
                    . "onto object '%s' failed | Error message: '%s'",
                    $eventPath,
                    $jsonMapper_Exception->getMessage()
                ),
                [__FUNCTION__]
            );
            exit(1);
        }

        $functionName = self::ARI_EVENT_HANDLER_FUNCTION_PREFIX . $ariEventType;

        $this->myApp->$functionName($mappedEventObject);

        $this->logger->debug(
            "Message successfully handled by your app: {$message}",
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
        $appName = Helper::getShortClassName($stasisApplication);

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
            $appName,
            $subscribeAllParameter
        );

        $this->logger->debug("URI to asterisk: '{$uri}'");

        return $uri;
    }

    /**
     * Extract the available public class function names of a class.
     *
     * @param string|object $classObjectOrPath ClassObject or Path
     *
     * @return string[]
     */
    private function extractPublicClassMethodNames($classObjectOrPath): array
    {
        try {
            $reflectionClass = new ReflectionClass($classObjectOrPath);
            $publicReflectionMethods =
                $reflectionClass->getMethods(
                    ReflectionMethod::IS_PUBLIC & ~ReflectionMethod::IS_STATIC
                );

            $publicClassMethodNames = [];
            foreach ($publicReflectionMethods as $method) {
                $publicClassMethodNames[] = $method->getName();
            }

            return $publicClassMethodNames;
        } catch (ReflectionException $e) {
            $this->logger->error($e->getMessage(), [__FUNCTION__]);
            exit(1);
        }
    }

    /**
     * Go through a list of available public class function names and
     * filter the functions with the reserved ARI event handler function prefix.
     *
     * @param string[] $myAppPublicClassMethodNames Public method names of a class
     *
     * @return string[]
     */
    private function filterAsteriskEventMessageFunctions(
        array $myAppPublicClassMethodNames
    ) {
        $ariEventMethodNames = [];

        foreach ($myAppPublicClassMethodNames as $methodName) {
            // Check for correct prefix syntax on incoming ARI events
            if (
                strpos(
                    $methodName,
                    self::ARI_EVENT_HANDLER_FUNCTION_PREFIX
                ) === 0
            ) {
                $methodName = (string) substr(
                    $methodName,
                    strlen(self::ARI_EVENT_HANDLER_FUNCTION_PREFIX)
                );

                if (
                class_exists(
                    "NgVoice\\AriClient\\Models\\Message\\" . $methodName
                )
                ) {
                    $ariEventMethodNames[] = $methodName;
                }
            }
        }

        return $ariEventMethodNames;
    }
}
