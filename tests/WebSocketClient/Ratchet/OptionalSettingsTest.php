<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\WebSocketClient\Ratchet;

use JsonMapper;
use Monolog\Logger;
use NgVoice\AriClient\RestClient\ResourceClient\Applications;
use NgVoice\AriClient\WebSocketClient\Ratchet\OptionalSettings;
use PHPUnit\Framework\TestCase;
use Ratchet\Client\Connector as RatchedConnector;
use React\EventLoop\LoopInterface;
use React\Socket\Connector as ReactConnector;

/**
 * Class OptionalSettingsTest
 *
 * @package NgVoice\AriClient\Tests\WebSocketClient\Ratchet
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

    public function testLoop()
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

    public function testReactConnector()
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

    public function testRatchetConnector()
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
}
