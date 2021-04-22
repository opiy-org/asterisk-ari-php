<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model\Message\Event;

use OpiyOrg\AriClient\Model\Message\Event\PlaybackFinished;
use OpiyOrg\AriClient\Model\Playback;
use OpiyOrg\AriClient\Tests\Helper;
use OpiyOrg\AriClient\Tests\Model\PlaybackTest;
use PHPUnit\Framework\TestCase;

/**
 * Class PlaybackFinishedTest
 *
 * @package OpiyOrg\AriClient\Tests\Model\Event
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
