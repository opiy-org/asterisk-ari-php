<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2019)
 */

namespace AriStasisApp\Tests\websocket_client;

use AriStasisApp\websocket_client\RemoteAppMessageHandler;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Nekland\Woketo\Core\AbstractConnection;
use Nekland\Woketo\Exception\WebsocketException;
use PHPUnit\Framework\TestCase;

/**
 * Class RemoteAppMessageHandlerTest
 * @package AriStasisApp\Tests\websocket_client
 */
class RemoteAppMessageHandlerTest extends TestCase
{
    /**
     * @return array
     * @throws \ReflectionException
     */
    public function remoteAppMessageHandlerStubProvider()
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
    public function test__construct(Client $guzzleClient)
    {
        $this->assertInstanceOf(
            RemoteAppMessageHandler::class,
            new RemoteAppMessageHandler([], $guzzleClient)
        );
    }

    /**
     * @dataProvider remoteAppMessageHandlerStubProvider
     * @param Client $guzzleClient
     * @throws \ReflectionException
     */
    public function testOnConnection(Client $guzzleClient)
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
     * @throws \ReflectionException
     */
    public function testOnMessage(Client $guzzleClient)
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
     * @throws \ReflectionException
     */
    public function testOnDisconnect(Client $guzzleClient)
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
     * @throws \ReflectionException
     */
    public function testOnError(Client $guzzleClient)
    {
        $remoteAppMessageHandler = new RemoteAppMessageHandler([], $guzzleClient);

        $abstractConnectionStub = $this->createMock(AbstractConnection::class);
        $webSocketException = $this->createMock(WebsocketException::class);

        /**
         * @var AbstractConnection $abstractConnectionStub
         * @var WebsocketException $webSocketException
         */
        $this->expectException('\Nekland\Woketo\Exception\WebsocketException');
        $remoteAppMessageHandler->onError($webSocketException, $abstractConnectionStub);
    }
}