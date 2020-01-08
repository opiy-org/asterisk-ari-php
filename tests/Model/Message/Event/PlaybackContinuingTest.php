<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model\Message\Event;

use NgVoice\AriClient\Model\Message\Event\PlaybackContinuing;
use NgVoice\AriClient\Model\Playback;
use NgVoice\AriClient\Tests\Helper;
use NgVoice\AriClient\Tests\Model\PlaybackTest;
use PHPUnit\Framework\TestCase;

/**
 * Class PlaybackContinuingTest
 *
 * @package NgVoice\AriClient\Tests\Model\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class PlaybackContinuingTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var PlaybackContinuing $playbackContinuing
         */
        $playbackContinuing = Helper::mapOntoAriEvent(
            PlaybackContinuing::class,
            [
                'playback' => PlaybackTest::RAW_ARRAY_REPRESENTATION,
            ]
        );
        $this->assertInstanceOf(Playback::class, $playbackContinuing->getPlayback());
    }
}
