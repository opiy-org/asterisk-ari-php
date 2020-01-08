<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Client\WebSocket\Ratchet;

use Monolog\Logger;
use NgVoice\AriClient\Client\Rest\Resource\Applications;
use NgVoice\AriClient\Client\WebSocket\Ratchet\OptionalSettings;
use Oktavlachs\DataMappingService\DataMappingService;
use PHPUnit\Framework\TestCase;
use Ratchet\Client\Connector as RatchedConnector;
use React\EventLoop\LoopInterface;
use React\Socket\Connector as ReactConnector;

/**
 * Class OptionalSettingsTest
 *
 * @package NgVoice\AriClient\Tests\WebSocket\Ratchet
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

    public function testLoop(): void
    {
        $optionalSettings = new OptionalSettings();
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
        $optionalSettings = new OptionalSettings();
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
        $optionalSettings = new OptionalSettings();
        $optionalSettings->setRatchetConnector(
            $this->createMock(RatchedConnector::class)
        );

        $this->assertInstanceOf(
            RatchedConnector::class,
            $optionalSettings->getRatchetConnector()
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
}
