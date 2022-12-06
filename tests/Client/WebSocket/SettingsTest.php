<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Client\WebSocket;

use OpiyOrg\AriClient\Client\Rest\Resource\Applications;
use OpiyOrg\AriClient\Client\WebSocket\Settings;
use PHPUnit\Framework\TestCase;

/**
 * Class WebSocketSettingsTest
 *
 * @package OpiyOrg\AriClient\Tests\WebSocket
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class SettingsTest extends TestCase
{
    private Settings $settings;

    public function setUp(): void
    {
        $this->settings = new Settings('asterisk', 'asterisk');
    }

    public function testConstruct(): void
    {
        $this->assertInstanceOf(Settings::class, $this->settings);
    }

    public function testErrorHandler(): void
    {
        $errorHandlerFunction = static function () {
        };
        $this->settings->setErrorHandler($errorHandlerFunction);
        $this->assertSame($errorHandlerFunction, $this->settings->getErrorHandler());
    }

    public function testIsWssEnabled(): void
    {
        $this->settings->setWssEnabled(true);
        $this->assertTrue($this->settings->isWssEnabled());
    }

    public function testIsSubscribeAll(): void
    {
        $this->settings->setIsSubscribeAll(true);

        $this->assertTrue($this->settings->isSubscribeAll());
    }

    public function testAriApplicationsClient(): void
    {
        $this->settings->setAriApplicationsClient(
            $this->createMock(Applications::class)
        );

        $this->assertInstanceOf(
            Applications::class,
            $this->settings->getAriApplicationsClient()
        );
    }
}
