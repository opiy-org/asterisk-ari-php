<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Client\WebSocket;

use OpiyOrg\AriClient\Client\WebSocket\Factory;
use OpiyOrg\AriClient\Client\WebSocket\Settings;
use OpiyOrg\AriClient\Client\WebSocket\WebSocketClientInterface;
use OpiyOrg\AriClient\StasisApplicationInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class FactoryTest
 *
 * @package OpiyOrg\AriClient\Tests\WebSocket
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
