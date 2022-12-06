<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model\Message\Event;

use OpiyOrg\AriClient\Model\Channel;
use OpiyOrg\AriClient\Model\Message\Event\ChannelHangupRequest;
use OpiyOrg\AriClient\Tests\Helper;
use OpiyOrg\AriClient\Tests\Model\ChannelTest;
use PHPUnit\Framework\TestCase;

/**
 * Class ChannelHangupRequestTest
 *
 * @package OpiyOrg\AriClient\Tests\Model\Event
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
                'soft' => true,
                'cause' => 45,
                'channel' => ChannelTest::RAW_ARRAY_REPRESENTATION,
            ]
        );
        $this->assertInstanceOf(Channel::class, $channelHangupRequest->getChannel());
        $this->assertSame(45, $channelHangupRequest->getCause());
        $this->assertTrue($channelHangupRequest->isSoft());
    }
}
