<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2019)
 */

namespace AriStasisApp\Tests\websocket_client;

use AriStasisApp\websocket_client\LocalAppMessageHandler;
use AriStasisApp\websocket_client\WebSocketClient;
use PHPUnit\Framework\TestCase;

/**
 * Class WebSocketClientTest
 * @package AriStasisApp\Tests\websocket_client
 */
class WebSocketClientTest extends TestCase
{

    /**
     * @throws \ReflectionException
     */
    public function test__construct()
    {
        $woketoWebSocketClientStub = $this->createMock(\Nekland\Woketo\Client\WebSocketClient::class);
        $localAppMessageHandler = $this->createMock(LocalAppMessageHandler::class);
        /**
         * @var \Nekland\Woketo\Client\WebSocketClient $woketoWebSocketClientStub
         * @var LocalAppMessageHandler $localAppMessageHandler
         */
        $this->assertInstanceOf(
            WebSocketClient::class,
            new WebSocketClient(['SomeApp'], $localAppMessageHandler, [], false, $woketoWebSocketClientStub)
        );

    }

    /**
     * @throws \ReflectionException
     */
    public function testStart()
    {
        $woketoWebSocketClientStub = $this->createMock('\Nekland\Woketo\Client\WebSocketClient');
        $localAppMessageHandler = $this->createMock(LocalAppMessageHandler::class);
        /**
         * @var \Nekland\Woketo\Client\WebSocketClient $woketoWebSocketClientStub
         * @var LocalAppMessageHandler $localAppMessageHandler
         */
        (new WebSocketClient(['SomeApp'], $localAppMessageHandler, [], false, $woketoWebSocketClientStub))
            ->start();
        $this->assertTrue(true, true);
    }
}
