<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2019)
 */

namespace AriStasisApp\Tests\WebSocketClient;

use AriStasisApp\WebSocketClient\LocalAppMessageHandler;
use AriStasisApp\WebSocketClient\WebSocketClient;
use PHPUnit\Framework\TestCase;

/**
 * Class WebSocketClientTest
 * @package AriStasisApp\Tests\WebSocketClient
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

    /**
     * @throws \ReflectionException
     */
    public function test__constructEmptyAppArrayThrowsException()
    {
        $woketoWebSocketClientStub = $this->createMock(\Nekland\Woketo\Client\WebSocketClient::class);
        $localAppMessageHandler = $this->createMock(LocalAppMessageHandler::class);
        $this->expectException('RuntimeException');
        /**
         * @var \Nekland\Woketo\Client\WebSocketClient $woketoWebSocketClientStub
         * @var LocalAppMessageHandler $localAppMessageHandler
         */
        $this->assertInstanceOf(
            WebSocketClient::class,
            new WebSocketClient([], $localAppMessageHandler, [], false, $woketoWebSocketClientStub)
        );
    }

    /**
     * @throws \ReflectionException
     */
    public function test__constructEmptyAppNameStringThrowsException()
    {
        $woketoWebSocketClientStub = $this->createMock(\Nekland\Woketo\Client\WebSocketClient::class);
        $localAppMessageHandler = $this->createMock(LocalAppMessageHandler::class);
        $this->expectException('RuntimeException');
        /**
         * @var \Nekland\Woketo\Client\WebSocketClient $woketoWebSocketClientStub
         * @var LocalAppMessageHandler $localAppMessageHandler
         */
        $this->assertInstanceOf(
            WebSocketClient::class,
            new WebSocketClient(['SomeApp', ''], $localAppMessageHandler, [], false, $woketoWebSocketClientStub)
        );
    }
}
