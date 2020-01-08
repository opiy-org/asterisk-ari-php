<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model\Message\Event;

use NgVoice\AriClient\Model\Channel;
use NgVoice\AriClient\Model\Message\Event\ChannelUnhold;
use NgVoice\AriClient\Tests\Helper;
use NgVoice\AriClient\Tests\Model\ChannelTest;
use PHPUnit\Framework\TestCase;

/**
 * Class ChannelUnholdTest
 *
 * @package NgVoice\AriClient\Tests\Model\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ChannelUnholdTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var ChannelUnhold $channelUnhold
         */
        $channelUnhold = Helper::mapOntoAriEvent(
            ChannelUnhold::class,
            [
                'channel' => ChannelTest::RAW_ARRAY_REPRESENTATION,
            ]
        );
        $this->assertInstanceOf(Channel::class, $channelUnhold->getChannel());
    }
}
