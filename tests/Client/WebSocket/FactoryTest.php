<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Client\WebSocket;

use NgVoice\AriClient\Client\WebSocket\Factory;
use NgVoice\AriClient\Client\WebSocket\Settings;
use NgVoice\AriClient\Client\WebSocket\WebSocketClientInterface;
use NgVoice\AriClient\StasisApplicationInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class FactoryTest
 *
 * @package NgVoice\AriClient\Tests\WebSocket
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class FactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $webSocketClientSettings = new Settings('asterisk', 'asterisk');
        $stasisApp = $this->createMock(StasisApplicationInterface::class);

        $this->assertInstanceOf(
            WebSocketClientInterface::class,
            Factory::create(
                $webSocketClientSettings,
                $stasisApp
            )
        );
    }

    public function testCreateRatchet(): void
    {
        $webSocketClientSettings = new Settings('asterisk', 'asterisk');
        $stasisApp = $this->createMock(StasisApplicationInterface::class);

        $this->assertInstanceOf(
            WebSocketClientInterface::class,
            Factory::createRatchet(
                $webSocketClientSettings,
                $stasisApp
            )
        );
    }

    public function testCreateWoketo(): void
    {
        $webSocketClientSettings = new Settings('asterisk', 'asterisk');
        $stasisApp = $this->createMock(StasisApplicationInterface::class);

        $this->assertInstanceOf(
            WebSocketClientInterface::class,
            Factory::createWoketo(
                $webSocketClientSettings,
                $stasisApp
            )
        );
    }
}
