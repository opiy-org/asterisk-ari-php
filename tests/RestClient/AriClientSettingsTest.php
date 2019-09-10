<?php


/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\RestClient;

use NgVoice\AriClient\RestClient\AriRestClientSettings;
use PHPUnit\Framework\TestCase;


/**
 * Class AriClientSettingsTest
 *
 * @package NgVoice\AriClient\Tests\RestClient
 *
 * @author Ahmad Hussain <ahmad@ng-voice.com>
 */
final class AriClientSettingsTest extends TestCase
{
    public function testAriClientSettingsParams(): void
    {
        /**
         * @var $ariClientSettings
         */

        $ariClientSettings = new AriRestClientSettings(
            'someUser',
            'password',
            true,
            '127.1.1.1',
            4000,
            '/ari'
        );
        $this->assertSame('someUser', $ariClientSettings->getAriUser());
        $this->assertSame('password', $ariClientSettings->getAriPassword());
        $this->assertTrue($ariClientSettings->isHttpsEnabled());
        $this->assertSame('127.1.1.1', $ariClientSettings->getHost());
        $this->assertSame(4000, $ariClientSettings->getPort());
        $this->assertSame('/ari', $ariClientSettings->getRootUri());
    }
}
