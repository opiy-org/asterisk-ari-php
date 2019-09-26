<?php

/** @copyright 2019 ng-voice GmbH */

namespace NgVoice\AriClient\Tests\WebSocketClient;

use NgVoice\AriClient\AsteriskStasisApplication;
use NgVoice\AriClient\WebSocketClient\{AriFilteredMessageHandler,
    ModifiedWoketoWebSocketClient,
    WebSocketClient,
    WebSocketClientSettings};
use PHPUnit\Framework\TestCase;

/**
 * Class WebSocketClientTest
 *
 * @package NgVoice\AriClient\Tests\WebSocketClient
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class WebSocketClientTest extends TestCase
{
    public function testConstruct(): void
    {
        $woketoWebSocketClientStub =
            $this->createMock(ModifiedWoketoWebSocketClient::class);
        $localAppMessageHandler = $this->createMock(AriFilteredMessageHandler::class);
        $stasisApp = $this->createMock(AsteriskStasisApplication::class);
        $webSocketSettings = $this->createMock(WebSocketClientSettings::class);

        /**
         * @var ModifiedWoketoWebSocketClient $woketoWebSocketClientStub
         * @var AriFilteredMessageHandler $localAppMessageHandler
         * @var WebSocketClientSettings $webSocketSettings
         * @var AsteriskStasisApplication $stasisApp
         */
        $this->assertInstanceOf(
            WebSocketClient::class,
            new WebSocketClient(
                $webSocketSettings,
                $stasisApp,
                $localAppMessageHandler,
                false,
                $woketoWebSocketClientStub
            )
        );
    }

    public function testStart(): void
    {

        $woketoWebSocketClientStub =
            $this->createMock(ModifiedWoketoWebSocketClient::class);
        $localAppMessageHandler = $this->createMock(AriFilteredMessageHandler::class);
        $stasisApp = $this->createMock(AsteriskStasisApplication::class);
        $webSocketSettings = $this->createMock(WebSocketClientSettings::class);

        /**
         * @var ModifiedWoketoWebSocketClient $woketoWebSocketClientStub
         * @var AriFilteredMessageHandler $localAppMessageHandler
         * @var WebSocketClientSettings $webSocketSettings
         * @var AsteriskStasisApplication $stasisApp
         */
        (new WebSocketClient(
            $webSocketSettings,
            $stasisApp,
            $localAppMessageHandler,
            false,
            $woketoWebSocketClientStub
        ))->start();

        $this->assertTrue(true, true);
    }
}
