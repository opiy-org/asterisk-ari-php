<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model\Message\Event;

use OpiyOrg\AriClient\Model\Bridge;
use OpiyOrg\AriClient\Model\Channel;
use OpiyOrg\AriClient\Model\Message\Event\ChannelEnteredBridge;
use OpiyOrg\AriClient\Tests\Helper;
use OpiyOrg\AriClient\Tests\Model\BridgeTest;
use OpiyOrg\AriClient\Tests\Model\ChannelTest;
use PHPUnit\Framework\TestCase;

/**
 * Class ChannelEnteredBridgeTest
 *
 * @package OpiyOrg\AriClient\Tests\Model\Event
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
