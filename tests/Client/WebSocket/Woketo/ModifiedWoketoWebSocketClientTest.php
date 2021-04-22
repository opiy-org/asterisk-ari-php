<?php

/** @copyright 2020 ng-voice GmbH */

namespace OpiyOrg\AriClient\Tests\Client\WebSocket;

use Nekland\Woketo\Client\Connection;
use OpiyOrg\AriClient\Client\WebSocket\Woketo\FilteredMessageHandler;
use OpiyOrg\AriClient\Client\WebSocket\Woketo\ModifiedWoketoWebSocketClient;
use PHPUnit\Framework\TestCase;
use React\EventLoop\LoopInterface;

/**
 * @package OpiyOrg\AriClient\Tests\WebSocket
 *
 * @author Ahmad Hussain <ahmad@ng-voice.com>
 */
class ModifiedWoketoWebSocketClientTest extends TestCase
{
    public function testStart(): void
    {
        /**
         * @var FilteredMessageHandler $mockedMessageHandler
         *
         * @var Connection $mockedConnection
         *
         * @var LoopInterface $mockedLoop
         *
         * @var $client
         */

        $mockedMessageHandler = $this->createMock(
            FilteredMessageHandler::class
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
