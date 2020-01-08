<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model\Message\Event;

use NgVoice\AriClient\Model\Channel;
use NgVoice\AriClient\Model\Message\Event\ChannelDtmfReceived;
use NgVoice\AriClient\Tests\Helper;
use NgVoice\AriClient\Tests\Model\ChannelTest;
use PHPUnit\Framework\TestCase;

/**
 * Class ChannelDtmfReceivedTest
 *
 * @package NgVoice\AriClient\Tests\Model\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ChannelDtmfReceivedTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        $channelDtmfReceived = [
            'duration_ms' => 1555,
            'digit'       => '4',
            'channel'     => ChannelTest::RAW_ARRAY_REPRESENTATION,
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
