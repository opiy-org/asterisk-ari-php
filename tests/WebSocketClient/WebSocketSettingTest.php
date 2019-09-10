<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace AriStasisApp\Tests\WebSocketClient;

use NgVoice\AriClient\WebSocketClient\WebSocketSettings;
use PHPUnit\Framework\TestCase;

/**
 * Class WebSocketSettingsTest
 *
 * @package NgVoice\AriClient\Tests\WebSocketClient
 *
 * @author Ahmad Hussain <ahmad@ng-voice.com>
 */
class WebSocketSettingTest extends TestCase
{
    public function testWebSocketParams(): void
    {
        /**
         * @var $webSocketSettings
         */
        $webSocketSettings = new WebSocketSettings(
            'someUser',
            'password',
            true,
            '127.1.1.1',
            4000,
            'file/folder'
        );
        $this->assertSame('someUser', $webSocketSettings->getUser());
        $this->assertSame('password', $webSocketSettings->getPassword());
        $this->assertTrue($webSocketSettings->isWssEnabled());
        $this->assertSame('127.1.1.1', $webSocketSettings->getHost());
        $this->assertSame(4000, $webSocketSettings->getPort());
        $this->assertSame('file/folder', $webSocketSettings->getRootUri());
    }
}
