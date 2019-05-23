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
     * @param AsteriskStasisApplication $myApp
     * @param AsteriskApplicationsClient $asteriskApplicationsClient
     * @param JsonMapper $jsonMapper
     */
    public function __construct(
        AsteriskStasisApplication $myApp,
        AsteriskApplicationsClient $asteriskApplicationsClient,
        JsonMapper $jsonMapper = null
    ) {
        $this->myApp = $myApp;
        $this->asteriskApplicationsClient = $asteriskApplicationsClient;

        if ($jsonMapper === null) {
            $this->jsonMapper = new JsonMapper();
        } else {
            $this->jsonMapper = $jsonMapper;
        }

        $this->logger = Helper::initLogger(Helper::getShortClassName($this));
    }

    /**
     * @inheritdoc
     *
     * On connection to the web socket, we tell Asterisk only to send Message we are
     * actually handling in our application. This will increase performance.
     */
    public function onConnection(AbstractConnection $connection): void
    {
        $this->logger->info('Connection to asterisk successful...');

        try {
            $myAppPublicClassMethodNames = $this->getPublicClassMethodNames($this->myApp);

            // Only use functions, that are named after a valid Asterisk message type
            $allowedMessages =
                $this->filterAsteriskEventMessageFunctions($myAppPublicClassMethodNames);

            $this->asteriskApplicationsClient->filter(
                Helper::getShortClassName($this->myApp),
                $allowedMessages
            );
        } catch (AsteriskRestInterfaceException $e) {
            $this->logger->error($e->getMessage(), [__FUNCTION__]);
        }

        $this->logger->debug('Set message filter in Asterisk.', [__FUNCTION__]);
        $this->logger->info('Waiting for Message.');
    }

    /**
     * Every incoming message from Asterisk will be handled within
     * the provided BasicStasisApp classes function
     *
     * @inheritdoc
     *
     * @param string $data
     * @param AbstractConnection $connection
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
            $functionName = lcfirst($ariEventType);
            $this->myApp->$functionName($mappedEventObject);
            $this->logger->debug(
                "Message successfully handled by your app: {$data}",
                [__FUNCTION__]
            );
        } catch (JsonMapper_Exception $jsonMapper_Exception) {
            $this->logger->error($jsonMapper_Exception->getMessage(), [__FUNCTION__]);
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
     * @param string|object $classObjectOrPath
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
     * @param array $myAppPublicClassMethodNames
     *
     * @return string[]
     */
    private function filterAsteriskEventMessageFunctions(
        array $myAppPublicClassMethodNames
    ): array {
        $ariEventMethodNames = [];

        foreach ($myAppPublicClassMethodNames as $methodName) {
            $methodName = ucfirst($methodName);

            if (
                class_exists(
                    "NgVoice\\AriClient\\Models\\Message\\" . $methodName
                ) === true
            ) {
                $ariEventMethodNames[] = $methodName;
            }
        }

        return $ariEventMethodNames;
    }
}
