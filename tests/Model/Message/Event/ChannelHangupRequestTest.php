<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model\Message\Event;

use NgVoice\AriClient\Model\Channel;
use NgVoice\AriClient\Model\Message\Event\ChannelHangupRequest;
use NgVoice\AriClient\Tests\Helper;
use NgVoice\AriClient\Tests\Model\ChannelTest;
use PHPUnit\Framework\TestCase;

/**
 * Class ChannelHangupRequestTest
 *
 * @package NgVoice\AriClient\Tests\Model\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ChannelHangupRequestTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var ChannelHangupRequest $channelHangupRequest
         */
        $channelHangupRequest = Helper::mapOntoAriEvent(
            ChannelHangupRequest::class,
            [
                'soft'    => true,
                'cause'   => 45,
                'channel' => ChannelTest::RAW_ARRAY_REPRESENTATION,
            ]
        );
        $this->assertInstanceOf(Channel::class, $channelHangupRequest->getChannel());
        $this->assertSame(45, $channelHangupRequest->getCause());
        $this->assertTrue($channelHangupRequest->isSoft());
    }
}
