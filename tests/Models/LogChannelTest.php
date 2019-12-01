<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models;

use JsonMapper_Exception;
use NgVoice\AriClient\Models\LogChannel;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class LogChannelTest
 *
 * @package NgVoice\AriClient\Tests\Models
 */
final class LogChannelTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var LogChannel $logChannel
         */
        $logChannel = Helper::mapAriResponseParametersToAriObject(
            'LogChannel',
            [
                'configuration' => '3',
                'type' => 'DEBUG,ERROR',
                'status' => 'enabled',
                'channel' => '/var/log/syslog'
            ]
        );
        $this->assertSame('enabled', $logChannel->getStatus());
        $this->assertSame('/var/log/syslog', $logChannel->getChannel());
        $this->assertSame('3', $logChannel->getConfiguration());
        $this->assertSame('DEBUG,ERROR', $logChannel->getType());
    }
}
