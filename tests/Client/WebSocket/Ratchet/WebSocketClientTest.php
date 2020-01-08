<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Client\WebSocket\Ratchet;

use Monolog\Logger;
use NgVoice\AriClient\Client\WebSocket\Ratchet\{OptionalSettings, WebSocketClient};
use NgVoice\AriClient\Client\WebSocket\Settings;
use NgVoice\AriClient\StasisApplicationInterface;
use PHPUnit\Framework\TestCase;
use Ratchet\Client\Connector as RatchetConnector;
use React\EventLoop\LoopInterface;
use React\Promise\PromiseInterface;
use React\Socket\Connector as ReactConnector;

/**
 * Class WebSocketClientTest
 *
 * @package NgVoice\AriClient\Tests\WebSocket\Ratchet
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

        $optionalSettings = new OptionalSettings();
        $optionalSettings->setReactConnector(
            $this->createMock(ReactConnector::class)
        );

        $promiseInterface = $this->createMock(PromiseInterface::class);
        $promiseInterface->method('then')->willReturn(true);

        $ratchetConnector = $this->createMock(RatchetConnector::class);
        $ratchetConnector->method('__invoke')->willReturn($promiseInterface);

        $optionalSettings->setRatchetConnector($ratchetConnector);

        /**
         * @var Settings $webSocketSettings
         * @var StasisApplicationInterface $stasisApp
         */
        $this->assertInstanceOf(
            WebSocketClient::class,
            new WebSocketClient(
                $webSocketSettings,
                $stasisApp,
                $optionalSettings
            )
        );

        $this->assertInstanceOf(
            WebSocketClient::class,
            new WebSocketClient(
                $webSocketSettings,
                $stasisApp,
                null
            )
        );
    }

    public function testCreateHandlesUriParseException(): void
    {
        $stasisApp = $this->createMock(StasisApplicationInterface::class);
        // URI parts not mocked, so this __construct call should stop the event loop.
        $webSocketSettings = $this->createMock(Settings::class);

        $optionalSettings = $this->createMock(OptionalSettings::class);
        $logger = $this->createMock(Logger::class);
        $logger->expects($this->once())->method('error');

        $optionalSettings->method('getLogger')->willReturn($logger);

        /**
         * @var Settings $webSocketSettings
         * @var StasisApplicationInterface $stasisApp
         */
        $this->assertInstanceOf(
            WebSocketClient::class,
            new WebSocketClient(
                $webSocketSettings,
                $stasisApp,
                $optionalSettings
            )
        );
    }

    public function testStart(): void
    {
        $stasisApp = $this->createMock(StasisApplicationInterface::class);
        $webSocketSettings = $this->createMock(Settings::class);

        $optionalSettings = new OptionalSettings();
        $optionalSettings->setReactConnector(
            $this->createMock(ReactConnector::class)
        );

        $promiseInterface = $this->createMock(PromiseInterface::class);
        $promiseInterface->method('then')->willReturn(true);

        $ratchetConnector = $this->createMock(RatchetConnector::class);
        $ratchetConnector->method('__invoke')->willReturn($promiseInterface);

        $optionalSettings->setRatchetConnector($ratchetConnector);

        /**
         * @var Settings $webSocketSettings
         * @var StasisApplicationInterface $stasisApp
         * @var OptionalSettings $optionalSettings
         */
        (new WebSocketClient(
            $webSocketSettings,
            $stasisApp,
            $optionalSettings
        ))->start();

        $this->assertTrue(true);
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
