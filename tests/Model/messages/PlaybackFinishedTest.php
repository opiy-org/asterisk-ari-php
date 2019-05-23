<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Models\{Message\PlaybackFinished, Playback};
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class PlaybackFinishedTest
 *
 * @package NgVoice\AriClient\Tests\Models\Message
 */
final class PlaybackFinishedTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var PlaybackFinished $playbackFinished
         */
        $playbackFinished = Helper::mapMessageParametersToAriObject(
            'PlaybackFinished',
            [
                'playback' => [
                    'next_media_uri' => 'ExampleUri',
                    'target_uri' => 'ExampleTargetUri',
                    'language' => 'en',
                    'state' => 'queued',
                    'media_uri' => 'ExampleMediaRui',
                    'id' => 'ExampleId'
                ]
            ]
        );
        $this->assertInstanceOf(Playback::class, $playbackFinished->getPlayback());
    }
}
