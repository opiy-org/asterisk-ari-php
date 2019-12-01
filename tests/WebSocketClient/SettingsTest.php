<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace AriStasisApp\Tests\WebSocketClient;

use NgVoice\AriClient\WebSocketClient\Settings;
use PHPUnit\Framework\TestCase;

/**
 * Class WebSocketSettingsTest
 *
 * @package NgVoice\AriClient\Tests\WebSocketClient
 *
 * @author Ahmad Hussain <ahmad@ng-voice.com>
 */
class SettingsTest extends TestCase
{
    public function testWebSocketParams(): void
    {
        /**
         * @var $webSocketSettings
         */
        $webSocketSettings = new Settings(
            'someUser',
            'password'
        );
        $webSocketSettings->setWssEnabled(true);
        $webSocketSettings->setHost('127.1.1.1');
        $webSocketSettings->setPort(4000);
        $webSocketSettings->setRootUri('file/folder');

        $this->assertSame('someUser', $webSocketSettings->getUser());
        $this->assertSame('password', $webSocketSettings->getPassword());
        $this->assertTrue($webSocketSettings->isWssEnabled());
        $this->assertSame('127.1.1.1', $webSocketSettings->getHost());
        $this->assertSame(4000, $webSocketSettings->getPort());
        $this->assertSame('file/folder', $webSocketSettings->getRootUri());
    }
}
