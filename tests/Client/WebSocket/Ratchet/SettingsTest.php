<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Client\WebSocket\Ratchet;

use NgVoice\AriClient\Client\WebSocket\Ratchet\Settings;
use PHPUnit\Framework\TestCase;
use Ratchet\Client\Connector as RatchetConnector;
use React\EventLoop\LoopInterface;
use React\Socket\Connector as ReactConnector;

/**
 * Class SettingsTest
 *
 * @package NgVoice\AriClient\Tests\WebSocket\Ratchet
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class SettingsTest extends TestCase
{
    public function testLoop(): void
    {
        $optionalSettings = new Settings();
        $optionalSettings->setLoop(
            $this->createMock(LoopInterface::class)
        );

        $this->assertInstanceOf(
            LoopInterface::class,
            $optionalSettings->getLoop()
        );
    }

    public function testReactConnector(): void
    {
        $optionalSettings = new Settings();
        $optionalSettings->setReactConnector(
            $this->createMock(ReactConnector::class)
        );

        $this->assertInstanceOf(
            ReactConnector::class,
            $optionalSettings->getReactConnector()
        );
    }

    public function testRatchetConnector(): void
    {
        $optionalSettings = new Settings();
        $optionalSettings->setRatchetConnector(
            $this->createMock(RatchetConnector::class)
        );

        $this->assertInstanceOf(
            RatchetConnector::class,
            $optionalSettings->getRatchetConnector()
        );
    }
}
