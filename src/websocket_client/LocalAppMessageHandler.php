<?php

/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\websocket_client;


use JsonMapper;
use JsonMapper_Exception;
use Monolog\Logger;
use AriStasisApp\BasicStasisApp;
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
     * WebHookMessageHandler constructor.
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

        try {
            $jsonEvent = $this->jsonMapper->map($decodedJson, new $ariEventType());
        }
        catch (JsonMapper_Exception $jsonMapper_Exception) {
            $this->logger->error($jsonMapper_Exception->getMessage());
            exit;
        }

        $functionName = lcfirst($ariEventType);

        if (method_exists($this->myApp, $functionName))
        {
            $this->myApp->$functionName($jsonEvent);
            $this->logger->debug("Message successfully handled.");
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