<?php

/** @copyright 2020 ng-voice GmbH */

namespace OpiyOrg\AriClient\Tests\Client\WebSocket\Woketo;

use OpiyOrg\AriClient\Client\WebSocket\Woketo\Settings as WoketoSettings;
use OpiyOrg\AriClient\Client\WebSocket\Woketo\{ModifiedWoketoWebSocketClient,
    WebSocketClient};
use OpiyOrg\AriClient\Client\WebSocket\Settings;
use OpiyOrg\AriClient\Exception\XdebugEnabledException;
use OpiyOrg\AriClient\StasisApplicationInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use React\EventLoop\LoopInterface;

/**
 * Class WebSocketClientTest
 *
 * @package OpiyOrg\AriClient\Tests\WebSocket\Woketo
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class WebSocketClientTest extends TestCase
{
    public function testConstruct(): void
    {
        $stasisApp = $this->createMock(StasisApplicationInterface::class);
        $webSocketSettings = new Settings('asterisk', 'asterisk');

        /**
         * @var Settings $webSocketSettings
         * @var StasisApplicationInterface $stasisApp
         * @var Settings $optionalSettings
         */
        $this->assertInstanceOf(
            WebSocketClient::class,
            new WebSocketClient(
                $webSocketSettings,
                $stasisApp,
            )
        );
    }

    public function testStart(): void
    {
        $stasisApp = $this->createMock(StasisApplicationInterface::class);
        $webSocketSettings = new Settings('asterisk', 'asterisk');

        $webSocketClient = new WebSocketClient(
            $webSocketSettings,
            $stasisApp
        );

        $webSocketClient->start();

        $this->assertTrue(true, true);
    }

    public function testStartThrowsException(): void
    {
        $stasisApp = $this->createMock(StasisApplicationInterface::class);
        $webSocketSettings = new Settings('asterisk', 'asterisk');

        $modifiedWoketoWebSocketClient = $this->createMock(
            ModifiedWoketoWebSocketClient::class
        );
        $modifiedWoketoWebSocketClient
            ->method('start')
            ->willThrowException(new XdebugEnabledException('Haha, a test!'));

        // Don't actually log the Exception message
        $logger = $this->createMock(LoggerInterface::class);
        $webSocketSettings->setLoggerInterface($logger);

        $optionalSettings = $this->createMock(WoketoSettings::class);
        $optionalSettings
            ->method('getModifiedWoketoWebSocketClient')
            ->willReturn($modifiedWoketoWebSocketClient);

        $webSocketClient = new WebSocketClient(
            $webSocketSettings,
            $stasisApp,
            $optionalSettings
        );

        // Exception is handled by the class
        $webSocketClient->start();

        $this->assertTrue(true, true);
    }

    public function testGetLoop(): void
    {
        $stasisApp = $this->createMock(StasisApplicationInterface::class);
        $webSocketSettings = new Settings('asterisk', 'asterisk');

        $webSocketClient = new WebSocketClient(
            $webSocketSettings,
            $stasisApp,
        );

        $this->assertInstanceOf(LoopInterface::class, $webSocketClient->getLoop());
    }
}
