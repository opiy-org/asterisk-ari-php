<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model\Message\Event;

use NgVoice\AriClient\Model\Bridge;
use NgVoice\AriClient\Model\Channel;
use NgVoice\AriClient\Model\Message\Event\ChannelEnteredBridge;
use NgVoice\AriClient\Tests\Helper;
use NgVoice\AriClient\Tests\Model\BridgeTest;
use NgVoice\AriClient\Tests\Model\ChannelTest;
use PHPUnit\Framework\TestCase;

/**
 * Class ChannelEnteredBridgeTest
 *
 * @package NgVoice\AriClient\Tests\Model\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ChannelEnteredBridgeTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var ChannelEnteredBridge $channelEnteredBridge
         */
        $channelEnteredBridge = Helper::mapOntoAriEvent(
            ChannelEnteredBridge::class,
            [
                'bridge'  => BridgeTest::RAW_ARRAY_REPRESENTATION,
                'channel' => ChannelTest::RAW_ARRAY_REPRESENTATION,
            ]
        );
        $this->assertInstanceOf(Bridge::class, $channelEnteredBridge->getBridge());
        $this->assertInstanceOf(Channel::class, $channelEnteredBridge->getChannel());
    }
}
