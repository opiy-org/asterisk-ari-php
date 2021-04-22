<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Client\WebSocket\Woketo;

use OpiyOrg\AriClient\Client\WebSocket\Woketo\{FilteredMessageHandler,
    ModifiedWoketoWebSocketClient,
    Settings};
use PHPUnit\Framework\TestCase;

/**
 * Class SettingsTest
 *
 * @package OpiyOrg\AriClient\Tests\WebSocket\Woketo
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class SettingsTest extends TestCase
{
    public function testModifiedWoketoWebSocketClient(): void
    {
        $optionalSettings = new Settings();
        $optionalSettings->setModifiedWoketoWebSocketClient(
            $this->createMock(ModifiedWoketoWebSocketClient::class)
        );

        $this->assertInstanceOf(
            ModifiedWoketoWebSocketClient::class,
            $optionalSettings->getModifiedWoketoWebSocketClient()
        );
    }

    public function testMessageHandlerInterface(): void
    {
        $optionalSettings = new Settings();
        $optionalSettings->setMessageHandlerInterface(
            $this->createMock(FilteredMessageHandler::class)
        );

        $this->assertInstanceOf(
            FilteredMessageHandler::class,
            $optionalSettings->getMessageHandlerInterface()
        );
    }
}
