<?php

/** @copyright 2019 ng-voice GmbH */

namespace NgVoice\AriClient\Tests\WebSocketClient\Woketo;

use Monolog\Logger;
use NgVoice\AriClient\Exception\XdebugEnabledException;
use NgVoice\AriClient\StasisApplicationInterface;
use NgVoice\AriClient\WebSocketClient\Settings;
use NgVoice\AriClient\WebSocketClient\Woketo\{ModifiedWoketoWebSocketClient,
    OptionalSettings,
    WebSocketClient};
use PHPUnit\Framework\TestCase;
use React\EventLoop\LoopInterface;

/**
 * Class WebSocketClientTest
 *
 * @package NgVoice\AriClient\Tests\WebSocketClient\Woketo
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class WebSocketClientTest extends TestCase
{
    public function testConstruct(): void
    {
        $stasisApp = $this->createMock(StasisApplicationInterface::class);
        $webSocketSettings = $this->createMock(Settings::class);
        $webSocketSettings->method('getHost')->willReturn('localhost');
        $webSocketSettings->method('getPort')->willReturn(8088);

        /**
         * @var Settings $webSocketSettings
         * @var StasisApplicationInterface $stasisApp
         * @var OptionalSettings $optionalSettings
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
        $webSocketSettings = $this->createMock(Settings::class);
        $webSocketSettings->method('getHost')->willReturn('localhost');
        $webSocketSettings->method('getPort')->willReturn(8088);
        $optionalSettings = $this->createMock(OptionalSettings::class);

        $webSocketClient = new WebSocketClient(
            $webSocketSettings,
            $stasisApp,
            $optionalSettings
        );

        $webSocketClient->start();

        $this->assertTrue(true, true);
    }

    public function testStartThrowsException()
    {
        $stasisApp = $this->createMock(StasisApplicationInterface::class);
        $webSocketSettings = $this->createMock(Settings::class);
        $webSocketSettings->method('getHost')->willReturn('localhost');
        $webSocketSettings->method('getPort')->willReturn(8088);

        $modifiedWoketoWebSocketClient = $this->createMock(
            ModifiedWoketoWebSocketClient::class
        );
        $modifiedWoketoWebSocketClient
            ->method('start')
            ->willThrowException(new XdebugEnabledException('Haha, a test!'));

        // Don't actually log the Exception message
        $logger = $this->createMock(Logger::class);

        $optionalSettings = $this->createMock(OptionalSettings::class);
        $optionalSettings
            ->method('getModifiedWoketoWebSocketClient')
            ->willReturn($modifiedWoketoWebSocketClient);
        $optionalSettings->method('getLogger')->willReturn($logger);

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
        $webSocketSettings = $this->createMock(Settings::class);
        $webSocketSettings->method('getHost')->willReturn('localhost');
        $webSocketSettings->method('getPort')->willReturn(8088);
        $optionalSettings = $this->createMock(OptionalSettings::class);

        $webSocketClient = new WebSocketClient(
            $webSocketSettings,
            $stasisApp,
            $optionalSettings
        );

        $this->assertInstanceOf(LoopInterface::class, $webSocketClient->getLoop());
    }
}
