<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Client\WebSocket\Woketo;

use Monolog\Logger;
use NgVoice\AriClient\Client\Rest\Resource\Applications;
use NgVoice\AriClient\Client\WebSocket\Woketo\{FilteredMessageHandler,
    ModifiedWoketoWebSocketClient,
    OptionalSettings};
use Oktavlachs\DataMappingService\DataMappingService;
use PHPUnit\Framework\TestCase;

/**
 * Class OptionalSettingsTest
 *
 * @package NgVoice\AriClient\Tests\WebSocket\Woketo
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class OptionalSettingsTest extends TestCase
{
    public function testSubscribeAll(): void
    {
        $optionalSettings = new OptionalSettings();
        $optionalSettings->setSubscribeAll(true);

        $this->assertTrue($optionalSettings->isSubscribeAll());
    }

    public function testAriApplicationsClient(): void
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

    public function testGetLogger(): void
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

    public function testDataMappingService(): void
    {
        $optionalSettings = new OptionalSettings();
        $optionalSettings->setDataMappingService(
            $this->createMock(DataMappingService::class)
        );

        $this->assertInstanceOf(
            DataMappingService::class,
            $optionalSettings->getDataMappingService()
        );
    }

    public function testModifiedWoketoWebSocketClient(): void
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

    public function testMessageHandlerInterface(): void
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
