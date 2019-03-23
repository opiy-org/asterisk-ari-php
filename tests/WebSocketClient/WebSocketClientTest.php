<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2019)
 */

namespace NgVoice\AriClient\Tests\WebSocketClient;

use NgVoice\AriClient\WebSocketClient\LocalAppMessageHandler;
use NgVoice\AriClient\WebSocketClient\WebSocketClient;
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * Class WebSocketClientTest
 * @package NgVoice\AriClient\Tests\WebSocketClient
 */
class WebSocketClientTest extends TestCase
{

    /**
     * @throws ReflectionException
     */
    public function test__construct(): void
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
     * @throws ReflectionException
     */
    public function testStart(): void
    {
        $woketoWebSocketClientStub = $this->createMock(\Nekland\Woketo\Client\WebSocketClient::class);
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
     * @throws ReflectionException
     */
    public function test__constructEmptyAppArrayThrowsException(): void
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
     * @throws ReflectionException
     */
    public function test__constructEmptyAppNameStringThrowsException(): void
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
