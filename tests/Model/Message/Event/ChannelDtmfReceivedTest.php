<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model\Message\Event;

use OpiyOrg\AriClient\Model\Channel;
use OpiyOrg\AriClient\Model\Message\Event\ChannelDtmfReceived;
use OpiyOrg\AriClient\Tests\Helper;
use OpiyOrg\AriClient\Tests\Model\ChannelTest;
use PHPUnit\Framework\TestCase;

/**
 * Class ChannelDtmfReceivedTest
 *
 * @package OpiyOrg\AriClient\Tests\Model\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ChannelDtmfReceivedTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        $channelDtmfReceived = [
            'duration_ms' => 1555,
            'digit' => '4',
            'channel' => ChannelTest::RAW_ARRAY_REPRESENTATION,
        ];

        $channelDtmfReceived = Helper::mapOntoAriEvent(
            ChannelDtmfReceived::class,
            $channelDtmfReceived
        );

        /**
         * @var ChannelDtmfReceived $channelDtmfReceived
         */
        $this->assertSame('4', $channelDtmfReceived->getDigit());
        $this->assertSame(1555, $channelDtmfReceived->getDurationMs());
        $this->assertInstanceOf(Channel::class, $channelDtmfReceived->getChannel());
    }
}
