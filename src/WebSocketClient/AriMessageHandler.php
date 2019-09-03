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
use NgVoice\AriClient\AsteriskStasisApplication;
use NgVoice\AriClient\Helper;

/**
 * Class AriMessageHandler
 *
 * @package NgVoice\AriClient\WebSocketClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class AriMessageHandler extends TextMessageHandler
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
     * AriMessageHandler constructor.
     *
     * @param AsteriskStasisApplication $myApp
     * @param JsonMapper|null $jsonMapper
     */
    public function __construct(
        AsteriskStasisApplication $myApp,
        JsonMapper $jsonMapper = null
    ) {
        $this->logger = Helper::initLogger(self::class);
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
     * Every incoming message from Asterisk will be checked on weather
     * it is handled within the provided BasicStasisApp class or not.
     */
    public function onMessage(string $data, AbstractConnection $connection): void
    {
        $this->logger->debug(
            "Received raw message from asterisk WebSocket server: {$data}"
        );
        $decodedJson = json_decode($data, false);
        $ariEventType = $decodedJson->type;
        $eventPath = "NgVoice\\AriClient\\Models\\Message\\" . $ariEventType;

        try {
            $mappedEventObject = $this->jsonMapper->map($decodedJson, new $eventPath());
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
    public function onError(
        WebsocketException $websocketException,
        AbstractConnection $connection
    ): void {
        $this->logger->error($websocketException->getMessage(), [__FUNCTION__]);
        throw $websocketException;
    }
}
