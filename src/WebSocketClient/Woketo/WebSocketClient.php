<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\WebSocketClient\Woketo;

use Nekland\Woketo\Message\MessageHandlerInterface;
use NgVoice\AriClient\{Exception\XdebugEnabledException,
    StasisApplicationInterface,
    WebSocketClient\AbstractWebSocketClient,
    WebSocketClient\Settings as WebSocketClientSettings};
use React\EventLoop\LoopInterface;

/**
 * ARI web socket client implementation using the nekland/woketo package.
 *
 * Within this library you should only either subscribe to one or all (e.g. proxy mode)
 * running StasisApps on Asterisk. It is a good idea - regarding to the concept
 * of 'separation of concerns' - to have a worker process for each of your applications,
 * so your code doesn't get messy.
 *
 * @package NgVoice\ArClient\WeSocketClient\Woketo
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class WebSocketClient extends AbstractWebSocketClient
{
    /**
     * @var ModifiedWoketoWebSocketClient
     */
    private $modifiedWoketoWebSocketClient;

    /**
     * @var MessageHandlerInterface
     */
    private $messageHandlerInterface;

    /**
     * WebSocketClient constructor.
     *
     * @param WebSocketClientSettings $webSocketClientSettings The settings for
     * the asterisk web socket.
     * @param StasisApplicationInterface $myApp Application to subscribe to
     * @param OptionalSettings $optionalSettings Optional settings for this web
     * socket client
     */
    public function __construct(
        WebSocketClientSettings $webSocketClientSettings,
        StasisApplicationInterface $myApp,
        OptionalSettings $optionalSettings = null
    ) {
        if ($optionalSettings === null) {
            $optionalSettings = new OptionalSettings();
        }

        parent::__construct(
            $webSocketClientSettings,
            $myApp,
            $optionalSettings->getAriApplicationsClient(),
            $optionalSettings->getLogger(),
            $optionalSettings->getJsonMapper()
        );

        $messageHandlerInterface = $optionalSettings->getMessageHandlerInterface();

        if ($messageHandlerInterface === null) {
            $messageHandlerInterface = new FilteredMessageHandler($this);
        }

        $this->messageHandlerInterface = $messageHandlerInterface;

        $uri = $this->createUri(
            $webSocketClientSettings,
            $myApp,
            $optionalSettings->isSubscribeAll()
        );

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
