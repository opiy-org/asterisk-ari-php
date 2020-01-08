<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model\Message\Event;

use NgVoice\AriClient\Model\Channel;
use NgVoice\AriClient\Model\Message\Event\ChannelDialplan;
use NgVoice\AriClient\Tests\Helper;
use NgVoice\AriClient\Tests\Model\ChannelTest;
use PHPUnit\Framework\TestCase;

/**
 * Class ChannelDialplanTest
 *
 * @package NgVoice\AriClient\Tests\Model\Event
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
