<?php

/** @copyright 2020 ng-voice GmbH */

namespace OpiyOrg\AriClient\Tests\Client\WebSocket\Woketo;

use Monolog\Logger;
use Nekland\Woketo\Core\AbstractConnection;
use Nekland\Woketo\Exception\WebsocketException;
use OpiyOrg\AriClient\Client\WebSocket\AbstractWebSocketClient;
use OpiyOrg\AriClient\Client\WebSocket\Woketo\{FilteredMessageHandler, WebSocketClient};
use OpiyOrg\AriClient\Exception\AsteriskRestInterfaceException;
use PHPUnit\Framework\TestCase;

/**
 * Class FilteredMessageHandlerTest
 *
 * @package OpiyOrg\AriClient\Tests\WebSocket\Woketo
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 * @author Ahmad Hussain <ahmad@ng-voice.com>
 */
class FilteredMessageHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        /**
         * @var Logger $loggerMock
         * @var AbstractWebSocketClient $abstractWebSocketClient
         */
        $loggerMock = $this->createMock(Logger::class);
        $abstractWebSocketClient = $this->createMock(WebSocketClient::class);

        $this->assertInstanceOf(
            FilteredMessageHandler::class,
            new FilteredMessageHandler(
                $abstractWebSocketClient,
                $loggerMock
            )
        );
    }

    /**
     * @return void
     *
     * @throws AsteriskRestInterfaceException
     */
    public function testOnConnection(): void
    {
        /**
         * @var Logger $loggerMock
         * @var AbstractWebSocketClient $abstractWebSocketClient
         */
        $loggerMock = $this->createMock(Logger::class);
        $abstractWebSocketClient = $this->createMock(WebSocketClient::class);

        $remoteAppMessageHandler =
            new FilteredMessageHandler(
                $abstractWebSocketClient,
                $loggerMock
            );

        $abstractConnectionStub = $this->createMock(AbstractConnection::class);

        /**
         * @var AbstractConnection $abstractConnectionStub
         */
        $remoteAppMessageHandler->onConnection($abstractConnectionStub);
        $this->assertTrue(true, true);
    }

    public function testOnMessage(): void
    {
        /**
         * @var Logger $loggerMock
         * @var AbstractWebSocketClient $abstractWebSocketClient
         */
        $loggerMock = $this->createMock(Logger::class);
        $abstractWebSocketClient = $this->createMock(WebSocketClient::class);

        $remoteAppMessageHandler =
            new FilteredMessageHandler(
                $abstractWebSocketClient,
                $loggerMock
            );

        $abstractConnectionStub = $this->createMock(AbstractConnection::class);

        /**
         * @var AbstractConnection $abstractConnectionStub
         * @var array $data Sample JSON Event
         */
        $data = [
            'message' => 'Example Event',
            'type'    => 'Dial',
            'id'      => 'id1',
        ];

        $remoteAppMessageHandler->onMessage(json_encode($data), $abstractConnectionStub);
        $this->assertTrue(true, true);
    }

    public function testOnDisconnect(): void
    {
        /**
         * @var Logger $loggerMock
         * @var AbstractWebSocketClient $abstractWebSocketClient
         */
        $loggerMock = $this->createMock(Logger::class);
        $abstractWebSocketClient = $this->createMock(WebSocketClient::class);

        $remoteAppMessageHandler =
            new FilteredMessageHandler(
                $abstractWebSocketClient,
                $loggerMock
            );

        $abstractConnectionStub = $this->createMock(AbstractConnection::class);

        /**
         * @var AbstractConnection $abstractConnectionStub
         */
        $remoteAppMessageHandler->onDisconnect($abstractConnectionStub);
        $this->assertTrue(true, true);
    }

    /**
     * @throws WebsocketException in case an error occurs within the web socket connection
     */
    public function testOnError(): void
    {
        /**
         * @var Logger $loggerMock
         * @var AbstractWebSocketClient $abstractWebSocketClient
         */
        $loggerMock = $this->createMock(Logger::class);
        $abstractWebSocketClient = $this->createMock(WebSocketClient::class);

        $remoteAppMessageHandler =
            new FilteredMessageHandler(
                $abstractWebSocketClient,
                $loggerMock
            );

        $abstractConnectionStub = $this->createMock(AbstractConnection::class);
        $webSocketException = $this->createMock(WebsocketException::class);

        /**
         * @var AbstractConnection $abstractConnectionStub
         * @var WebsocketException $webSocketException
         */
        $this->expectException(WebsocketException::class);
        $remoteAppMessageHandler->onError($webSocketException, $abstractConnectionStub);
    }

    public function testOnBinary(): void
    {
        /**
         * @var Logger $loggerMock
         * @var AbstractWebSocketClient $abstractWebSocketClient
         */
        $loggerMock = $this->createMock(Logger::class);
        $abstractWebSocketClient = $this->createMock(WebSocketClient::class);

        $remoteAppMessageHandler =
            new FilteredMessageHandler(
                $abstractWebSocketClient,
                $loggerMock
            );

        /**
         * @var AbstractConnection $abstractConnectionStub
         */
        $abstractConnectionStub = $this->createMock(AbstractConnection::class);

        $remoteAppMessageHandler->onBinary('someData', $abstractConnectionStub);

        $this->assertTrue(true);
    }
}
