<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\websocket_client;


use AriStasisApp\BasicStasisApp;
use JsonMapper;
use JsonMapper_Exception;
use Monolog\Logger;
use Nekland\Woketo\Core\AbstractConnection;
use Nekland\Woketo\Exception\WebsocketException;
use Nekland\Woketo\Message\TextMessageHandler;
use function AriStasisApp\{getShortClassName, initLogger};

/**
 * Class LocalAppMessageHandler
 *
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
     */
    function __construct(BasicStasisApp $myApp)
    {
        $this->myApp = $myApp;
        $this->jsonMapper = new JsonMapper();
        $this->logger = initLogger(getShortClassName($this));
    }

    /**
     * @param AbstractConnection $connection
     */
    public function onConnection(AbstractConnection $connection): void
    {
        $this->logger->debug('Connection to asterisk successfully. Waiting for messages...');
    }

    /**
     * @param string $data
     * @param AbstractConnection $connection
     */
    public function onMessage(string $data, AbstractConnection $connection): void
    {
        $this->logger->debug("Received raw message from asterisk WebSocket server: {$data}");

        $decodedJson = json_decode($data);
        $ariEventType = $decodedJson->type;
        $eventPath = "AriStasisApp\\models\\messages\\" . $ariEventType;

        try {
            $mappedEventObject = $this->jsonMapper->map($decodedJson, new $eventPath);
        } catch (JsonMapper_Exception $jsonMapper_Exception) {
            $this->logger->error($jsonMapper_Exception->getMessage());
            exit;
        }
        $this->logger->debug(print_r($mappedEventObject, true));
        $functionName = lcfirst($ariEventType);
        $this->logger->debug("Message successfully handled by app.");

        if (method_exists($this->myApp, $functionName)) {
            $this->myApp->$functionName($mappedEventObject);
            $this->logger->debug("Message successfully handled by your app.");
        } else {
            $this->logger->debug("Message was ignored by your app.");
        }
    }

    /**
     * @param AbstractConnection $connection
     */
    public function onDisconnect(AbstractConnection $connection): void
    {
        $this->logger->info('Connection to Asterisk was closed.');
    }

    /**
     * @param WebsocketException $websocketException
     * @param AbstractConnection $connection
     * @throws WebsocketException
     */
    public function onError(WebsocketException $websocketException, AbstractConnection $connection): void
    {
        $this->logger->error($websocketException->getMessage());
        throw $websocketException;
    }
}