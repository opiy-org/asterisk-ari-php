<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\WebSocketClient;

use JsonMapper;
use JsonMapper_Exception;
use Monolog\Logger;
use Nekland\Woketo\Core\AbstractConnection;
use Nekland\Woketo\Exception\WebsocketException;
use Nekland\Woketo\Message\TextMessageHandler;
use NgVoice\AriClient\{AsteriskStasisApplication,
    Exception\AsteriskRestInterfaceException,
    Helper,
    RestClient\Applications as AsteriskApplicationsClient};
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

/**
 * Class AriFilteredMessageHandler tells Asterisk to send only messages to the
 * Stasis application that are actually handled.
 *
 * @package NgVoice\AriClient\WebSocketClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class AriFilteredMessageHandler extends TextMessageHandler
{
    /**
     * Prefix to show that a function defined within an
     * StasisApplication class handles a certain ARI event.
     */
    private const ARI_EVENT_HANDLER_FUNCTION_PREFIX = 'onAriEvent';

    /**
     * @var AsteriskStasisApplication
     */
    private $myApp;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var JsonMapper
     */
    private $jsonMapper;

    /**
     * @var AsteriskApplicationsClient
     */
    private $asteriskApplicationsClient;

    /**
     * RemoteAppMessageHandler constructor.
     *
     * @param AsteriskStasisApplication $myApp Asterisk Application
     * @param AsteriskApplicationsClient $asteriskApplicationsClient Application Client
     * @param JsonMapper|null $jsonMapper Map JSON into an Object
     * @param Logger|null $logger The logger for the message handler
     */
    public function __construct(
        AsteriskStasisApplication $myApp,
        AsteriskApplicationsClient $asteriskApplicationsClient,
        JsonMapper $jsonMapper = null,
        Logger $logger = null
    ) {
        $this->myApp = $myApp;
        $this->asteriskApplicationsClient = $asteriskApplicationsClient;

        if ($jsonMapper === null) {
            $this->jsonMapper = new JsonMapper();
        } else {
            $this->jsonMapper = $jsonMapper;
        }

        if ($logger === null) {
            $logger = Helper::initLogger(self::class);
        }

        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     *
     * On connection to the web socket, we tell Asterisk only to send Message we are
     * actually handling in our application. This will increase performance.
     */
    public function onConnection(AbstractConnection $connection): void
    {
        $this->logger->info("Successfully connected to Asterisk");

        $myAppPublicClassMethodNames = $this->getPublicClassMethodNames($this->myApp);

        // Only use functions, that are named after a valid Asterisk message type
        $allowedMessages = $this
            ->filterAsteriskEventMessageFunctions($myAppPublicClassMethodNames);

        $applicationName = Helper::getShortClassName($this->myApp);

        try {
            $this->asteriskApplicationsClient->filter(
                $applicationName,
                $allowedMessages
            );
        } catch (AsteriskRestInterfaceException $e) {
            $this->logger->error($e->getMessage(), [__FUNCTION__]);
            exit(1);
        }

        $this->logger->debug(
            'Successfully set event filter for app in Asterisk',
            [__FUNCTION__]
        );

        $this->logger->info(
            sprintf(
                "Waiting for the following incoming Asterisk channel events -> '%s'",
                print_r($allowedMessages, true)
            )
        );
    }

    /**
     * Every incoming message from Asterisk will be handled within
     * the provided AsteriskStasisApplication
     *
     * @inheritdoc
     *
     * @param string $data Message Data
     * @param AbstractConnection $connection Connection Settings
     *
     * @return void
     */
    public function onMessage(string $data, AbstractConnection $connection): void
    {
        $this->logger->debug(
            "Received raw message from asterisk WebSocket server: {$data}",
            [__FUNCTION__]
        );
        $decodedJson = json_decode($data, false);
        $ariEventType = $decodedJson->type;
        $eventPath = "NgVoice\\AriClient\\Models\\Message\\" . $ariEventType;

        try {
            $mappedEventObject = $this->jsonMapper->map($decodedJson, new $eventPath());
            $functionName = self::ARI_EVENT_HANDLER_FUNCTION_PREFIX . $ariEventType;
            $this->myApp->$functionName($mappedEventObject);
            $this->logger->debug(
                "Message successfully handled by your app: {$data}",
                [__FUNCTION__]
            );
        } catch (JsonMapper_Exception $jsonMapper_Exception) {
            $this->logger->error($jsonMapper_Exception->getMessage(), [__FUNCTION__]);
            exit(1);
        }
    }

    /**
     * @inheritdoc
     */
    public function onDisconnect(AbstractConnection $connection): void
    {
        $this->logger->warning('Connection to Asterisk was closed.', [__FUNCTION__]);
    }

    /**
     * @inheritdoc
     *
     * @throws WebsocketException When something goes wrong during the web socket
     * connection.
     */
    public function onError(
        WebsocketException $websocketException,
        AbstractConnection $connection
    ): void {
        $this->logger->error($websocketException->getMessage(), [__FUNCTION__]);
        throw $websocketException;
    }

    /**
     * @param string|object $classObjectOrPath ClassObject or Path
     *
     * @return string[]
     */
    private function getPublicClassMethodNames($classObjectOrPath): array
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
     * @param string[] $myAppPublicClassMethodNames Method names of Public Classes
     *
     * @return string[]
     */
    private function filterAsteriskEventMessageFunctions(
        $myAppPublicClassMethodNames
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
            }

            if (class_exists("NgVoice\\AriClient\\Models\\Message\\" . $methodName)) {
                $ariEventMethodNames[] = $methodName;
            }
        }

        return $ariEventMethodNames;
    }
}
