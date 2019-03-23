<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2019)
 */

namespace NgVoice\AriClient\Tests\WebSocketClient;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Nekland\Woketo\Core\AbstractConnection;
use Nekland\Woketo\Exception\WebsocketException;
use NgVoice\AriClient\WebSocketClient\RemoteAppMessageHandler;
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * Class RemoteAppMessageHandlerTest
 * @package NgVoice\AriClient\Tests\WebSocketClient
 */
class RemoteAppMessageHandlerTest extends TestCase
{
    /**
     * @return array
     * @throws ReflectionException
     */
    public function remoteAppMessageHandlerStubProvider(): array
    {
        $guzzleClientStub = $this->createMock(Client::class);
        $guzzleClientStub->method('request')->willReturn(new Response(200));
        /**
         * @var Client $guzzleClientStub
         */
        return [
            'setup local message handler' =>
                [$guzzleClientStub]
        ];
    }

    /**
     * @dataProvider remoteAppMessageHandlerStubProvider
     * @param Client $guzzleClient
     */
    public function test__construct(Client $guzzleClient): void
    {
        $this->assertInstanceOf(
            RemoteAppMessageHandler::class,
            new RemoteAppMessageHandler([], $guzzleClient)
        );
    }

    /**
     * @dataProvider remoteAppMessageHandlerStubProvider
     * @param Client $guzzleClient
     * @throws ReflectionException
     */
    public function testOnConnection(Client $guzzleClient): void
    {
        $remoteAppMessageHandler = new RemoteAppMessageHandler([], $guzzleClient);

        $abstractConnectionStub = $this->createMock(AbstractConnection::class);

        /**
         * @var AbstractConnection $abstractConnectionStub
         */
        $remoteAppMessageHandler->onConnection($abstractConnectionStub);
        $this->assertTrue(true, true);
    }

    /**
     * @dataProvider remoteAppMessageHandlerStubProvider
     * @param Client $guzzleClient
     * @throws ReflectionException
     */
    public function testOnMessage(Client $guzzleClient): void
    {
        $remoteAppMessageHandler = new RemoteAppMessageHandler([], $guzzleClient);
        $abstractConnectionStub = $this->createMock(AbstractConnection::class);

        /**
         * @var AbstractConnection $abstractConnectionStub
         */
        $remoteAppMessageHandler->onMessage(
            json_encode(
                [
                    'asterisk_id' => '12345',
                    'application' => 'ExampleApp',
                    'type' => 'MissingParams',
                    ['param1', 'param2']
                ]
            ),
            $abstractConnectionStub
        );
        $this->assertTrue(true, true);
    }

    /**
     * @dataProvider remoteAppMessageHandlerStubProvider
     * @param Client $guzzleClient
     * @throws ReflectionException
     */
    public function testOnDisconnect(Client $guzzleClient): void
    {
        $remoteAppMessageHandler = new RemoteAppMessageHandler([], $guzzleClient);

        $abstractConnectionStub = $this->createMock(AbstractConnection::class);

        /**
         * @var AbstractConnection $abstractConnectionStub
         */
        $remoteAppMessageHandler->onDisconnect($abstractConnectionStub);
        $this->assertTrue(true, true);
    }

    /**
     * @dataProvider remoteAppMessageHandlerStubProvider
     * @param Client $guzzleClient
     * @throws WebsocketException
     * @throws ReflectionException
     */
    public function testOnError(Client $guzzleClient): void
    {
        $remoteAppMessageHandler = new RemoteAppMessageHandler([], $guzzleClient);

        $abstractConnectionStub = $this->createMock(AbstractConnection::class);
        $webSocketException = $this->createMock(WebsocketException::class);

        /**
         * @var AbstractConnection $abstractConnectionStub
         * @var WebsocketException $webSocketException
         */
        $this->expectException(WebsocketException::class);
        $remoteAppMessageHandler->onError($webSocketException, $abstractConnectionStub);
    }
}