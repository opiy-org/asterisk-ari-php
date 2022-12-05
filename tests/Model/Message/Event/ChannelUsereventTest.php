<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model\Message\Event;

use OpiyOrg\AriClient\Model\{Bridge, Channel, Endpoint};
use OpiyOrg\AriClient\Model\Message\Event\ChannelUserevent;
use OpiyOrg\AriClient\Tests\Helper;
use OpiyOrg\AriClient\Tests\Model\BridgeTest;
use OpiyOrg\AriClient\Tests\Model\ChannelTest;
use PHPUnit\Framework\TestCase;

/**
 * Class ChannelUsereventTest
 *
 * @package OpiyOrg\AriClient\Tests\Model\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ChannelUsereventTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var ChannelUserevent $channelUserEvent
         */
        $channelUserEvent = Helper::mapOntoAriEvent(
            ChannelUserevent::class,
            [
                'eventname' => 'ExampleEvent',
                'bridge' => BridgeTest::RAW_ARRAY_REPRESENTATION,
                'userevent' => [
                    'someEvent' => 'someValue',
                ],
                'endpoint' => [
                    'state' => 'online',
                    'technology' => 'ExampleTechnology',
                    'channel_ids' => [],
                    'resource' => 'ExampleResource',
                ],
                'channel' => ChannelTest::RAW_ARRAY_REPRESENTATION,
            ]
        );
        $this->assertSame('ExampleEvent', $channelUserEvent->getEventname());
        $this->assertInstanceOf(Bridge::class, $channelUserEvent->getBridge());
        $this->assertIsObject($channelUserEvent->getUserevent());
        $this->assertObjectHasAttribute('someEvent', $channelUserEvent->getUserevent());
        $this->assertSame('someValue', $channelUserEvent->getUserevent()->someEvent);
        $this->assertInstanceOf(Endpoint::class, $channelUserEvent->getEndpoint());
        $this->assertInstanceOf(Channel::class, $channelUserEvent->getChannel());
    }
}
