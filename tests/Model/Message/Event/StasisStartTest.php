<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model\Message\Event;

use NgVoice\AriClient\Model\Channel;
use NgVoice\AriClient\Model\Message\Event\StasisStart;
use NgVoice\AriClient\Tests\Helper;
use NgVoice\AriClient\Tests\Model\ChannelTest;
use PHPUnit\Framework\TestCase;

/**
 * Class StasisStartTest
 *
 * @package NgVoice\AriClient\Tests\Model\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class StasisStartTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var StasisStart $stasisStart
         */
        $stasisStart = Helper::mapOntoAriEvent(
            StasisStart::class,
            [
                'channel'         => ChannelTest::RAW_ARRAY_REPRESENTATION,
                'replace_channel' => ChannelTest::RAW_ARRAY_REPRESENTATION,
                'args'            => [
                    'some',
                    'args',
                    'are',
                    'cool',
                ],
            ]
        );
        $this->assertInstanceOf(Channel::class, $stasisStart->getChannel());
        $this->assertInstanceOf(Channel::class, $stasisStart->getReplaceChannel());
        $this->assertSame(['some', 'args', 'are', 'cool'], $stasisStart->getArgs());
    }
}
