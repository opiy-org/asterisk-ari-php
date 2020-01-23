<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Client\WebSocket\Ratchet;

use NgVoice\AriClient\Client\WebSocket\Settings;
use NgVoice\AriClient\Client\WebSocket\Ratchet\{Settings as RatchetSettings, WebSocketClient};
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
        $webSocketSettings = new Settings('asterisk', 'asterisk');

        $optionalSettings = new RatchetSettings();
        $optionalSettings->setReactConnector(
            $this->createMock(ReactConnector::class)
        );

        $promiseInterface = $this->createMock(PromiseInterface::class);
        $promiseInterface->method('then')->willReturn(true);

        $ratchetConnector = $this->createMock(RatchetConnector::class);
        $ratchetConnector->method('__invoke')->willReturn($promiseInterface);

        $optionalSettings->setRatchetConnector($ratchetConnector);

        /**
         * @var RatchetSettings $webSocketSettings
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

    public function testStart(): void
    {
        $stasisApp = $this->createMock(StasisApplicationInterface::class);
        $webSocketSettings = new Settings('asterisk', 'asterisk');

        $optionalSettings = new RatchetSettings();
        $optionalSettings->setReactConnector(
            $this->createMock(ReactConnector::class)
        );

        $promiseInterface = $this->createMock(PromiseInterface::class);
        $promiseInterface->method('then')->willReturn(true);

        $ratchetConnector = $this->createMock(RatchetConnector::class);
        $ratchetConnector->method('__invoke')->willReturn($promiseInterface);

        $optionalSettings->setRatchetConnector($ratchetConnector);

        /**
         * @var RatchetSettings $webSocketSettings
         * @var StasisApplicationInterface $stasisApp
         * @var RatchetSettings $optionalSettings
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
        $webSocketSettings = new Settings('asterisk', 'asterisk');

        $webSocketClient = new WebSocketClient(
            $webSocketSettings,
            $stasisApp,
        );

        $this->assertInstanceOf(LoopInterface::class, $webSocketClient->getLoop());
    }
}
