<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Client\WebSocket\Woketo;

use Monolog\Logger;
use NgVoice\AriClient\Client\Rest\Resource\Applications;
use NgVoice\AriClient\Client\WebSocket\Woketo\{FilteredMessageHandler,
    ModifiedWoketoWebSocketClient,
    Settings};
use PHPUnit\Framework\TestCase;

/**
 * Class SettingsTest
 *
 * @package NgVoice\AriClient\Tests\WebSocket\Woketo
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class SettingsTest extends TestCase
{
    public function testSubscribeAll(): void
    {
        $optionalSettings = new Settings();
        $optionalSettings->setSubscribeAll(true);

        $this->assertTrue($optionalSettings->isSubscribeAll());
    }

    public function testAriApplicationsClient(): void
    {
        $optionalSettings = new Settings();
        $optionalSettings->setAriApplicationsClient(
            $this->createMock(Applications::class)
        );

        $this->assertInstanceOf(
            Applications::class,
            $optionalSettings->getAriApplicationsClient()
        );
    }

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
