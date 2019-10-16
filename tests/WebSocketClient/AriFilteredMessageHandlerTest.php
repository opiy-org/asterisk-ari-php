<?php

/** @copyright 2019 ng-voice GmbH */

namespace NgVoice\AriClient\Tests\WebSocketClient;

use Monolog\Logger;
use Nekland\Woketo\Core\AbstractConnection;
use Nekland\Woketo\Exception\WebsocketException;
use NgVoice\AriClient\AsteriskStasisApplication;
use NgVoice\AriClient\RestClient\Applications;
use NgVoice\AriClient\WebSocketClient\AriFilteredMessageHandler;
use PHPUnit\Framework\TestCase;

/**
 * Class AriFilteredMessageHandlerTest
 *
 * @package NgVoice\AriClient\Tests\WebSocketClient
 * @author Lukas Stermann <lukas@ng-voice.com>
 * @author Ahmad Hussain <ahmad@ng-voice.com>
 */
class AriFilteredMessageHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        /**
         * @var AsteriskStasisApplication $stasisAppMock
         */
        $stasisAppMock = $this->createMock(AsteriskStasisApplication::class);

        /**
         * @var Applications $applicationsClientMock
         */
        $applicationsClientMock = $this->createMock(Applications::class);

        $this->assertInstanceOf(
            AriFilteredMessageHandler::class,
            new AriFilteredMessageHandler(
                $stasisAppMock,
                $applicationsClientMock
            )
        );
    }

    public function testOnConnection(): void
    {
        /**
         * @var AsteriskStasisApplication $stasisAppMock
         * @var Applications $applicationsClientMock
         */
        $stasisAppMock = $this->createMock(AsteriskStasisApplication::class);
        $applicationsClientMock = $this->createMock(Applications::class);


        /**
         * @var Logger $loggerMock
         */
        $loggerMock = $this->createMock(Logger::class);

        $remoteAppMessageHandler =
            new AriFilteredMessageHandler(
                $stasisAppMock,
                $applicationsClientMock,
                null,
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
         * @var AsteriskStasisApplication $stasisAppMock
         * @var Applications $applicationsClientMock
         */
        $stasisAppMock = new class () implements AsteriskStasisApplication
        {
            public function dial(): void
            {
                // Create Mock Instance of DIAL Event
            }
        };
        $applicationsClientMock = $this->createMock(Applications::class);

        $remoteAppMessageHandler =
            new AriFilteredMessageHandler($stasisAppMock, $applicationsClientMock);

        $abstractConnectionStub = $this->createMock(AbstractConnection::class);

        /**
         * @var AbstractConnection $abstractConnectionStub
         * @var array $data Sample JSON Message
         */
        $data = [
            'message' => 'Example Message',
            'type' => 'Dial',
            'id' => 'id1'
        ];
        $remoteAppMessageHandler->onMessage(json_encode($data), $abstractConnectionStub);
        $this->assertTrue(true, true);
    }

    public function testOnDisconnect(): void
    {
        /**
         * @var AsteriskStasisApplication $stasisAppMock
         * @var Applications $applicationsClientMock
         */
        $stasisAppMock = $this->createMock(AsteriskStasisApplication::class);
        $applicationsClientMock = $this->createMock(Applications::class);

        /**
         * @var Logger $loggerMock
         */
        $loggerMock = $this->createMock(Logger::class);

        $remoteAppMessageHandler =
            new AriFilteredMessageHandler(
                $stasisAppMock,
                $applicationsClientMock,
                null,
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
         * @var AsteriskStasisApplication $stasisAppMock
         * @var Applications $applicationsClientMock
         */
        $stasisAppMock = $this->createMock(AsteriskStasisApplication::class);
        $applicationsClientMock = $this->createMock(Applications::class);


        /**
         * @var Logger $loggerMock
         */
        $loggerMock = $this->createMock(Logger::class);

        $remoteAppMessageHandler =
            new AriFilteredMessageHandler(
                $stasisAppMock,
                $applicationsClientMock,
                null,
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
}
