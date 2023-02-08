<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Client\WebSocket\Ratchet;

use Exception;
use OpiyOrg\AriClient\Client\WebSocket\{AbstractWebSocketClient, Settings as WebSocketClientSettings};
use OpiyOrg\AriClient\Exception\AsteriskRestInterfaceException;
use OpiyOrg\AriClient\StasisApplicationInterface;
use Ratchet\Client\Connector as RatchetConnector;
use Ratchet\Client\WebSocket as RatchetWebSocket;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\EventLoop\{Factory as ReactPhpEventLoopFactory, LoopInterface as ReactPhpEventLoopInterface};
use React\Socket\Connector as ReactConnector;

/**
 * A Ratchet ARI web socket client implementation.
 *
 * @package OpiyOrg\AriClient\Client\WebSocket\Ratchet
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 * @internal
 *
 */
class WebSocketClient extends AbstractWebSocketClient
{
    private ReactPhpEventLoopInterface $loop;

    /**
     * WebSocket constructor.
     *
     * @param WebSocketClientSettings $webSocketClientSettings The settings
     * for this web socket client
     * @param StasisApplicationInterface $stasisApplication The web socket client
     * @param Settings|null $optionalSettings Optional settings for
     * this web socket client
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

        $loop = $optionalSettings->getLoop();

        if ($loop === null) {
            $loop = ReactPhpEventLoopFactory::create();
        }

        $this->loop = $loop;

        $reactConnector = $optionalSettings->getReactConnector();

        if ($reactConnector === null) {
            $reactConnector = new ReactConnector($loop);
        }

        $ratchetConnector = $optionalSettings->getRatchetConnector();

        if ($ratchetConnector === null) {
            $ratchetConnector = new RatchetConnector($loop, $reactConnector);
        }

        // Configure the event handlers for the web socket client
        $uri = $this->createUri($stasisApplication);

        $ratchetConnector($uri)
            ->then(
                function (RatchetWebSocket $ratchetWebSocket) {
                    $this->messageHandler($ratchetWebSocket);
                    $this->closeConnectionHandler($ratchetWebSocket);
                    $this->connectionHandler();
                },
                function (Exception $e) use ($loop) {
                    $this->logger->error(
                        sprintf(
                            "ARI Connection error | Code -> '%s' | Event -> '%s'",
                            $e->getCode(),
                            $e->getMessage()
                        ),
                        [__FUNCTION__]
                    );

                    $loop->stop();
                }
            );
    }

    /**
     * @inheritDoc
     */
    public function getLoop(): ReactPhpEventLoopInterface
    {
        return $this->loop;
    }

    /**
     * Handle incoming ARI events on a ratchet web socket client.
     *
     * @param RatchetWebSocket $ratchetWebSocket The ratchet web socket
     * this handler shall target
     */
    private function messageHandler(RatchetWebSocket $ratchetWebSocket): void
    {
        $ratchetWebSocket->on(
            'message',
            function (MessageInterface $message) {
                if ($this->isInDebugMode) {
                    $errorMessage = sprintf(
                        "Asterisk web socket server sent raw message: '%s'",
                        (string)$message
                    );

                    $this->logger->debug($errorMessage, [__FUNCTION__]);
                }

                parent::onMessageHandlerLogic((string)$message);
            }
        );
    }

    /**
     * Handle a closed connection on a ratchet web socket client.
     *
     * @param RatchetWebSocket $ratchetWebSocket The ratchet web socket
     * this handler shall target
     */
    private function closeConnectionHandler(RatchetWebSocket $ratchetWebSocket): void
    {
        $ratchetWebSocket->on(
            'close',
            function ($code = null, $reason = null) {
                $errorMessage = sprintf(
                    'Connection to Asterisk web socket server closed. '
                    . "ErrorCode '%s' | Event: '%s'",
                    (string)$code,
                    (string)$reason
                );

                $this->logger->error($errorMessage, [__FUNCTION__]);
            }
        );
    }

    /**
     * Handle a new established connection on a ratchet web socket client.
     *
     * @throws AsteriskRestInterfaceException In case the connection handler logic fails
     */
    private function connectionHandler(): void
    {
        $this->logger->info(
            'Successfully connected to Asterisk web socket server',
            [__FUNCTION__]
        );

        $this->onConnectionHandlerLogic();
    }

    /**
     * @inheritDoc
     */
    public function start(): void
    {
        $this->loop->run();
    }
}
