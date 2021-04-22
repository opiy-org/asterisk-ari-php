<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model\Message\Event;

use OpiyOrg\AriClient\Model\Channel;
use OpiyOrg\AriClient\Model\Message\Event\ChannelDialplan;
use OpiyOrg\AriClient\Tests\Helper;
use OpiyOrg\AriClient\Tests\Model\ChannelTest;
use PHPUnit\Framework\TestCase;

/**
 * Class ChannelDialplanTest
 *
 * @package OpiyOrg\AriClient\Tests\Model\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ChannelDialplanTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var ChannelDialplan $channelDialplan
         */
        $channelDialplan = Helper::mapOntoAriEvent(
            ChannelDialplan::class,
            [
                'dialplan_app'      => 'MyExampleStasisApp',
                'dialplan_app_data' => 'ExampleAppData',
                'channel'           => ChannelTest::RAW_ARRAY_REPRESENTATION,
            ]
        );
        $this->assertInstanceOf(Channel::class, $channelDialplan->getChannel());
        $this->assertSame('MyExampleStasisApp', $channelDialplan->getDialplanApp());
        $this->assertSame('ExampleAppData', $channelDialplan->getDialplanAppData());
    }
}
