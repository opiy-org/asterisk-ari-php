<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\WebSocketClient\Woketo;

use JsonMapper;
use Monolog\Logger;
use NgVoice\AriClient\RestClient\ResourceClient\Applications;
use NgVoice\AriClient\WebSocketClient\Woketo\FilteredMessageHandler;
use NgVoice\AriClient\WebSocketClient\Woketo\ModifiedWoketoWebSocketClient;
use NgVoice\AriClient\WebSocketClient\Woketo\OptionalSettings;
use PHPUnit\Framework\TestCase;

/**
 * Class OptionalSettingsTest
 *
 * @package NgVoice\AriClient\Tests\WebSocketClient\Woketo
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class OptionalSettingsTest extends TestCase
{
    public function testSubscribeAll()
    {
        $optionalSettings = new OptionalSettings();
        $optionalSettings->setSubscribeAll(true);

        $this->assertTrue($optionalSettings->isSubscribeAll());
    }

    public function testAriApplicationsClient()
    {
        $optionalSettings = new OptionalSettings();
        $optionalSettings->setAriApplicationsClient(
            $this->createMock(Applications::class)
        );

        $this->assertInstanceOf(
            Applications::class,
            $optionalSettings->getAriApplicationsClient()
        );
    }

    public function testGetLogger()
    {
        $optionalSettings = new OptionalSettings();
        $optionalSettings->setLogger(
            $this->createMock(Logger::class)
        );

        $this->assertInstanceOf(
            Logger::class,
            $optionalSettings->getLogger()
        );
    }

    public function testJsonMapper()
    {
        $optionalSettings = new OptionalSettings();
        $optionalSettings->setJsonMapper(
            $this->createMock(JsonMapper::class)
        );

        $this->assertInstanceOf(
            JsonMapper::class,
            $optionalSettings->getJsonMapper()
        );
    }

    public function testModifiedWoketoWebSocketClient()
    {
        $optionalSettings = new OptionalSettings();
        $optionalSettings->setModifiedWoketoWebSocketClient(
            $this->createMock(ModifiedWoketoWebSocketClient::class)
        );

        $this->assertInstanceOf(
            ModifiedWoketoWebSocketClient::class,
            $optionalSettings->getModifiedWoketoWebSocketClient()
        );
    }

    public function testMessageHandlerInterface()
    {
        $optionalSettings = new OptionalSettings();
        $optionalSettings->setMessageHandlerInterface(
            $this->createMock(FilteredMessageHandler::class)
        );

        $this->assertInstanceOf(
            FilteredMessageHandler::class,
            $optionalSettings->getMessageHandlerInterface()
        );
    }
}
