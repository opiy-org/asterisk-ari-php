<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;

use NgVoice\AriClient\Model\LogChannel;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class LogChannelTest
 *
 * @package NgVoice\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class LogChannelTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var LogChannel $logChannel
         */
        $logChannel = Helper::mapOntoInstance(
            [
                'configuration' => '3',
                'type'          => 'DEBUG,ERROR',
                'status'        => 'enabled',
                'channel'       => '/var/log/syslog',
            ],
            new LogChannel()
        );
        $this->assertSame('enabled', $logChannel->getStatus());
        $this->assertSame('/var/log/syslog', $logChannel->getChannel());
        $this->assertSame('3', $logChannel->getConfiguration());
        $this->assertSame('DEBUG,ERROR', $logChannel->getType());
    }
}
