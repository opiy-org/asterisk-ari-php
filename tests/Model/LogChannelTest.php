<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model;

use OpiyOrg\AriClient\Model\LogChannel;
use OpiyOrg\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class LogChannelTest
 *
 * @package OpiyOrg\AriClient\Tests\Model
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
