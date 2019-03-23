<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\WebSocketClient;


use GuzzleHttp\Exception\GuzzleException;
use JsonMapper;
use JsonMapper_Exception;
use Monolog\Logger;
use Nekland\Woketo\Core\AbstractConnection;
use Nekland\Woketo\Exception\WebsocketException;
use Nekland\Woketo\Message\TextMessageHandler;
use NgVoice\AriClient\BasicStasisApp;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use function NgVoice\AriClient\{getShortClassName, initLogger};

/**
 * Class LocalAppFilteredMessageHandler
 * @package NgVoice\AriStasisApp\WebSocketClient
 */
class LocalAppFilteredMessageHandler extends TextMessageHandler
{
    /**
     * @var BasicStasisApp
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
     * RemoteAppMessageHandler constructor.
     * @param BasicStasisApp $myApp
     * @param JsonMapper|null $jsonMapper
     */
    public function __construct(BasicStasisApp $myApp, JsonMapper $jsonMapper = null)
    {
        $this->logger = initLogger(getShortClassName($this));
        $this->myApp = $myApp;

        if ($jsonMapper === null) {
            $this->jsonMapper = new JsonMapper();
        } else {
            $this->jsonMapper = $jsonMapper;
        }
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
            // Look for public methods via reflection to scan the needed Asterisk messages.
            $myAppPublicClassMethodNames = $this->getPublicClassMethodNames($this->myApp);
            $basicStasisAppPublicClassMethodNames = $this->getPublicClassMethodNames(BasicStasisApp::class);

            // Only use the public methods
            $allowedMessages = array_diff($myAppPublicClassMethodNames, $basicStasisAppPublicClassMethodNames);
            // Reindex the allowedMessages array so we can loop through it
            $allowedMessages = array_values($allowedMessages);

            $sizeAllowedMessages = count($allowedMessages);
            for ($i = 0; $i < $sizeAllowedMessages; $i++) {
                $allowedMessages[$i] = ucfirst($allowedMessages[$i]);
            }
            $applicationsClient = $this->myApp->getApplicationsClient();
            $applicationsClient->filter(getShortClassName($this->myApp), $allowedMessages);
        } catch (GuzzleException $e) {
            $this->logger->error($e->getMessage(), [__FUNCTION__]);
        }

        $this->logger->debug('Set message filter in Asterisk.', [__FUNCTION__]);
        $this->logger->info('Waiting for Message.');
    }

    /**
     * @inheritdoc
     *
     * Every incoming message from Asterisk will be handled within
     * the provided BasicStasisApp classes function
     */
    public function onMessage(string $data, AbstractConnection $connection): void
    {
        $this->logger->debug("Received raw message from asterisk WebSocket server: {$data}", [__FUNCTION__]);
        $decodedJson = json_decode($data);
        $ariEventType = $decodedJson->type;
        $eventPath = "NgVoice\\AriClient\\Model\\Message\\" . $ariEventType;

        try {
            $mappedEventObject = $this->jsonMapper->map($decodedJson, new $eventPath);
            $functionName = lcfirst($ariEventType);
            $this->myApp->$functionName($mappedEventObject);
            $this->logger->debug("Message successfully handled by your app: {$data}", [__FUNCTION__]);
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
     * @throws WebsocketException
     */
    public function onError(WebsocketException $websocketException, AbstractConnection $connection): void
    {
        $this->logger->error($websocketException->getMessage(), [__FUNCTION__]);
        throw $websocketException;
    }

    /**
     * @param string $classPath
     * @return string[]
     */
    private function getPublicClassMethodNames(string $classPath): array
    {
        try {
            $reflectionClass = new ReflectionClass($classPath);
            $publicReflectionMethods =
                $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC & ~ReflectionMethod::IS_STATIC);

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
}