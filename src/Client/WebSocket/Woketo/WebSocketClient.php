<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Client\WebSocket\Woketo;

use Nekland\Woketo\Message\MessageHandlerInterface;
use OpiyOrg\AriClient\Client\WebSocket\{AbstractWebSocketClient,
    Settings as WebSocketClientSettings};
use OpiyOrg\AriClient\Exception\XdebugEnabledException;
use OpiyOrg\AriClient\StasisApplicationInterface;
use React\EventLoop\LoopInterface;

/**
 * ARI web socket client implementation using the nekland/woketo package.
 *
 * Within this library you should only either subscribe to one or all (e.g. proxy mode)
 * running StasisApps on Asterisk. It is a good idea - regarding to the concept
 * of 'separation of concerns' - to have a worker process for each of your applications,
 * so your code doesn't get messy.
 *
 * @package OpiyOrg\AriClient\Client\WebSocket\Woketo
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class WebSocketClient extends AbstractWebSocketClient
{
    private ModifiedWoketoWebSocketClient $modifiedWoketoWebSocketClient;

    private MessageHandlerInterface $messageHandlerInterface;

    /**
     * WebSocket constructor.
     *
     * @param WebSocketClientSettings $webSocketClientSettings The settings for
     * the asterisk web socket.
     * @param StasisApplicationInterface $stasisApplication Application to subscribe to
     * @param Settings $optionalSettings Optional settings for this web
     * socket client implementation
     */
    public function __construct(
        WebSocketClientSettings $webSocketClientSettings,
        StasisApplicationInterface $stasisApplication,
        ?Settings $optionalSettings = null
    ) {
        if ($optionalSettings === null) {
            $optionalSettings = new Settings();
        }

        parent::__construct($webSocketClientSettings, $stasisApplication);

        $messageHandlerInterface = $optionalSettings->getMessageHandlerInterface();

        if ($messageHandlerInterface === null) {
            $messageHandlerInterface = new FilteredMessageHandler($this);
        }

        $this->messageHandlerInterface = $messageHandlerInterface;

        $uri = $this->createUri($webSocketClientSettings, $stasisApplication);

        $modifiedWoketoWebSocketClient = $optionalSettings
            ->getModifiedWoketoWebSocketClient();

        if ($modifiedWoketoWebSocketClient === null) {
            $modifiedWoketoWebSocketClient = new ModifiedWoketoWebSocketClient($uri);
        }

        $this->modifiedWoketoWebSocketClient = $modifiedWoketoWebSocketClient;
    }

    /**
     * @inheritDoc
     */
    public function start(): void
    {
        try {
            $this->modifiedWoketoWebSocketClient->start($this->messageHandlerInterface);
        } catch (XdebugEnabledException $e) {
            $this->logger->error($e->getMessage(), [__FUNCTION__]);
        }
    }

    /**
     * @inheritDoc
     */
    public function getLoop(): LoopInterface
    {
        return $this->modifiedWoketoWebSocketClient->getLoop();
    }
}
