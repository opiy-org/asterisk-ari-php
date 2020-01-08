<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model\Message\Event;

use NgVoice\AriClient\Model\Channel;
use NgVoice\AriClient\Model\Message\Event\ChannelTalkingFinished;
use NgVoice\AriClient\Tests\Helper;
use NgVoice\AriClient\Tests\Model\ChannelTest;
use PHPUnit\Framework\TestCase;

/**
 * Class ChannelTalkingFinishedTest
 *
 * @package NgVoice\AriClient\Tests\Model\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ChannelTalkingFinishedTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var ChannelTalkingFinished $channelTalkingFinished
         */
        $channelTalkingFinished = Helper::mapOntoAriEvent(
            ChannelTalkingFinished::class,
            [
                'channel'  => ChannelTest::RAW_ARRAY_REPRESENTATION,
                'duration' => 44,
            ]
        );
        $this->assertInstanceOf(Channel::class, $channelTalkingFinished->getChannel());
        $this->assertSame(44, $channelTalkingFinished->getDuration());
    }
}
