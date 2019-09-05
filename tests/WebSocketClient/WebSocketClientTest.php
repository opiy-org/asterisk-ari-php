<?php

/** @copyright 2019 ng-voice GmbH */

namespace NgVoice\AriClient\Tests\WebSocketClient;
use NgVoice\AriClient\AsteriskStasisApplication;
use NgVoice\AriClient\WebSocketClient\{AriFilteredMessageHandler,
    WebSocketClient,
    WebSocketSettings};
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
            $this->createMock(\Nekland\Woketo\Client\WebSocketClient::class);
        $localAppMessageHandler = $this->createMock(AriFilteredMessageHandler::class);
        $stasisApp = $this->createMock(AsteriskStasisApplication::class);
        $webSocketSettings = $this->createMock(WebSocketSettings::class);

        /**
         * @var \Nekland\Woketo\Client\WebSocketClient $woketoWebSocketClientStub
         * @var AriFilteredMessageHandler $localAppMessageHandler
         * @var WebSocketSettings $webSocketSettings
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
            $this->createMock(\Nekland\Woketo\Client\WebSocketClient::class);
        $localAppMessageHandler = $this->createMock(AriFilteredMessageHandler::class);
        $stasisApp = $this->createMock(AsteriskStasisApplication::class);
        $webSocketSettings = $this->createMock(WebSocketSettings::class);

        /**
         * @var \Nekland\Woketo\Client\WebSocketClient $woketoWebSocketClientStub
         * @var AriFilteredMessageHandler $localAppMessageHandler
         * @var WebSocketSettings $webSocketSettings
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
