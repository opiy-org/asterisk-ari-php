<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\WebSocketClient;

use NgVoice\AriClient\StasisApplicationInterface;
use NgVoice\AriClient\WebSocketClient\Factory;
use NgVoice\AriClient\WebSocketClient\Settings;
use NgVoice\AriClient\WebSocketClient\WebSocketClientInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class FactoryTest
 *
 * @package NgVoice\AriClient\Tests\WebSocketClient
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
