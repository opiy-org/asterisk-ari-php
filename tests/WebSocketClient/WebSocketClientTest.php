<?php

/** @copyright 2019 ng-voice GmbH */

namespace NgVoice\AriClient\Tests\WebSocketClient;

use NgVoice\AriClient\AsteriskStasisApplication;
use NgVoice\AriClient\WebSocketClient\{AriMessageHandler,
    WebSocketClient,
    WebSocketSettings};
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * Class WebSocketClientTest
 *
 * @package NgVoice\AriClient\Tests\WebSocketClient
 */
class WebSocketClientTest extends TestCase
{
    /**
     * @throws ReflectionException
     */
    public function test__construct(): void
    {
        $woketoWebSocketClientStub =
            $this->createMock(\Nekland\Woketo\Client\WebSocketClient::class);
        $localAppMessageHandler = $this->createMock(AriMessageHandler::class);
        $stasisApp = $this->createMock(AsteriskStasisApplication::class);
        $webSocketSettings = $this->createMock(WebSocketSettings::class);

        /**
         * @var \Nekland\Woketo\Client\WebSocketClient $woketoWebSocketClientStub
         * @var AriMessageHandler $localAppMessageHandler
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

    /**
     * @throws ReflectionException
     */
    public function testStart(): void
    {
        $woketoWebSocketClientStub =
            $this->createMock(\Nekland\Woketo\Client\WebSocketClient::class);
        $localAppMessageHandler = $this->createMock(AriMessageHandler::class);
        $stasisApp = $this->createMock(AsteriskStasisApplication::class);
        $webSocketSettings = $this->createMock(WebSocketSettings::class);

        /**
         * @var \Nekland\Woketo\Client\WebSocketClient $woketoWebSocketClientStub
         * @var AriMessageHandler $localAppMessageHandler
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
