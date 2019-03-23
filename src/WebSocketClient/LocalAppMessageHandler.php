<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\WebSocketClient;


use JsonMapper;
use JsonMapper_Exception;
use Monolog\Logger;
use Nekland\Woketo\Core\AbstractConnection;
use Nekland\Woketo\Exception\WebsocketException;
use Nekland\Woketo\Message\TextMessageHandler;
use NgVoice\AriClient\BasicStasisApp;
use function NgVoice\AriClient\{getShortClassName, initLogger};

/**
 * Class LocalAppMessageHandler
 * @package NgVoice\AriClient\WebSocketClient
 */
class LocalAppMessageHandler extends TextMessageHandler
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
     */
    public function onConnection(AbstractConnection $connection): void
    {
        $this->logger->info('Waiting for Message.');
    }

    /**
     * @inheritdoc
     *
     * Every incoming message from Asterisk will be checked on weather it is handled within
     * the provided BasicStasisApp class or not.
     */
    public function onMessage(string $data, AbstractConnection $connection): void
    {
        $this->logger->debug("Received raw message from asterisk WebSocket server: {$data}");
        $decodedJson = json_decode($data);
        $ariEventType = $decodedJson->type;
        $eventPath = "NgVoice\\AriClient\\Model\\Message\\" . $ariEventType;

        try {
            $mappedEventObject = $this->jsonMapper->map($decodedJson, new $eventPath);
        } catch (JsonMapper_Exception $jsonMapper_Exception) {
            $this->logger->error($jsonMapper_Exception->getMessage());
            exit;
        }
        $this->logger->debug(print_r($mappedEventObject, true));
        $functionName = lcfirst($ariEventType);
        $this->logger->debug('Message successfully handled by app.');

        if (method_exists($this->myApp, $functionName)) {
            $this->myApp->$functionName($mappedEventObject);
            $this->logger->debug('Message successfully handled by your app.');
        } else {
            $this->logger->debug('Message was ignored by your app.');
        }
    }

    /**
     * @inheritdoc
     */
    public function onDisconnect(AbstractConnection $connection): void
    {
        $this->logger->info('Connection to Asterisk was closed.', [__FUNCTION__]);
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
}