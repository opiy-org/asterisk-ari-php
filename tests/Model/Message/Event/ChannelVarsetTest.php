<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model\Message\Event;

use NgVoice\AriClient\Model\Channel;
use NgVoice\AriClient\Model\Message\Event\ChannelVarset;
use NgVoice\AriClient\Tests\Helper;
use NgVoice\AriClient\Tests\Model\ChannelTest;
use PHPUnit\Framework\TestCase;

/**
 * Class ChannelVarsetTest
 *
 * @package NgVoice\AriClient\Tests\Model\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ChannelVarsetTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var ChannelVarset $channelVarSet
         */
        $channelVarSet = Helper::mapOntoAriEvent(
            ChannelVarset::class,
            [
                'variable' => 'TestVar',
                'value'    => 'TestValue',
                'channel'  => ChannelTest::RAW_ARRAY_REPRESENTATION,
            ]
        );
        $this->assertInstanceOf(Channel::class, $channelVarSet->getChannel());
        $this->assertSame('TestVar', $channelVarSet->getVariable());
        $this->assertSame('TestValue', $channelVarSet->getValue());
    }
}
