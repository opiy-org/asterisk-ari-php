<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model\Message\Event;

use OpiyOrg\AriClient\Model\Channel;
use OpiyOrg\AriClient\Model\Message\Event\ChannelTalkingFinished;
use OpiyOrg\AriClient\Tests\Helper;
use OpiyOrg\AriClient\Tests\Model\ChannelTest;
use PHPUnit\Framework\TestCase;

/**
 * Class ChannelTalkingFinishedTest
 *
 * @package OpiyOrg\AriClient\Tests\Model\Event
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
                'channel' => ChannelTest::RAW_ARRAY_REPRESENTATION,
                'duration' => 44,
            ]
        );
        $this->assertInstanceOf(Channel::class, $channelTalkingFinished->getChannel());
        $this->assertSame(44, $channelTalkingFinished->getDuration());
    }
}
