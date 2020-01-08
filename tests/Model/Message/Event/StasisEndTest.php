<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model\Message\Event;

use NgVoice\AriClient\Model\Channel;
use NgVoice\AriClient\Model\Message\Event\StasisEnd;
use NgVoice\AriClient\Tests\Helper;
use NgVoice\AriClient\Tests\Model\ChannelTest;
use PHPUnit\Framework\TestCase;

/**
 * Class StasisEndTest
 *
 * @package NgVoice\AriClient\Tests\Model\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class StasisEndTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var StasisEnd $stasisEnd
         */
        $stasisEnd = Helper::mapOntoAriEvent(
            StasisEnd::class,
            [
                'channel' => ChannelTest::RAW_ARRAY_REPRESENTATION,
            ]
        );
        $this->assertInstanceOf(Channel::class, $stasisEnd->getChannel());
    }
}
