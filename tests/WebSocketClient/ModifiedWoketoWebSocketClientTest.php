<?php

/** @copyright 2019 ng-voice GmbH */

namespace NgVoice\AriClient\Tests\WebSocketClient;

use Nekland\Woketo\Client\Connection;
use Nekland\Woketo\Client\ModifiedWoketoWebSocketClient;
use NgVoice\AriClient\WebSocketClient\AriFilteredMessageHandler;
use PHPUnit\Framework\TestCase;
use React\EventLoop\LoopInterface;

/**
 * @package NgVoice\AriClient\Tests\WebSocketClient
 *
 * @author Ahmad Hussain <ahmad@ng-voice.com>
 */
class ModifiedWoketoWebSocketClientTest extends TestCase
{
    public function testStart(): void
    {
        /**
         * @var AriFilteredMessageHandler $mockedMessageHandler
         *
         * @var Connection $mockedConnection
         *
         * @var LoopInterface $mockedLoop
         *
         * @var $client
         */

        $mockedMessageHandler = $this->createMock(
            AriFilteredMessageHandler::class
        );
        $mockedConnection = $this->createMock(Connection::class);
        $mockedLoop = $this->createMock(LoopInterface::class);
        $client = new ModifiedWoketoWebSocketClient('ws://localhost:8000');
        $client->start($mockedMessageHandler, $mockedConnection, $mockedLoop);

        $this->assertTrue(true, true);
    }

    public function testGetConfig(): void
    {
        /**
         * @var $client
         *
         * @var $configArray
         */
        $client = new ModifiedWoketoWebSocketClient('ws://localhost:8000');
        $configArray = [
            'frame' => [],
            'message' => [],
            'prod' => true,
            'ssl' => [],
            'dns' => null,
        ];

        $client->setConfig($configArray);

        $this->assertEquals($configArray, $client->getConfig());
    }
}