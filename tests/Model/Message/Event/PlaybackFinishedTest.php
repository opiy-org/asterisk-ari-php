<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model\Message\Event;

use NgVoice\AriClient\Model\Message\Event\PlaybackFinished;
use NgVoice\AriClient\Model\Playback;
use NgVoice\AriClient\Tests\Helper;
use NgVoice\AriClient\Tests\Model\PlaybackTest;
use PHPUnit\Framework\TestCase;

/**
 * Class PlaybackFinishedTest
 *
 * @package NgVoice\AriClient\Tests\Model\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class PlaybackFinishedTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var PlaybackFinished $playbackFinished
         */
        $playbackFinished = Helper::mapOntoAriEvent(
            PlaybackFinished::class,
            [
                'playback' => PlaybackTest::RAW_ARRAY_REPRESENTATION,
            ]
        );
        $this->assertInstanceOf(Playback::class, $playbackFinished->getPlayback());
    }
}
