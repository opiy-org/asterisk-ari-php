<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model\Message\Event;

use NgVoice\AriClient\Model\Channel;
use NgVoice\AriClient\Model\Message\Event\ChannelHold;
use NgVoice\AriClient\Tests\Helper;
use NgVoice\AriClient\Tests\Model\ChannelTest;
use PHPUnit\Framework\TestCase;

/**
 * Class ChannelHoldTest
 *
 * @package NgVoice\AriClient\Tests\Model\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ChannelHoldTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var ChannelHold $channelHold
         */
        $channelHold = Helper::mapOntoAriEvent(
            ChannelHold::class,
            [
                'channel'    => ChannelTest::RAW_ARRAY_REPRESENTATION,
                'musicclass' => 'SomeMusicClass',
            ]
        );
        $this->assertInstanceOf(Channel::class, $channelHold->getChannel());
        $this->assertSame('SomeMusicClass', $channelHold->getMusicclass());
    }
}
