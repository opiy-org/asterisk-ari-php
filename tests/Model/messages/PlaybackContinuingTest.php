<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Model\{Message\PlaybackContinuing, Playback};
use PHPUnit\Framework\TestCase;
use function NgVoice\AriClient\Tests\mapMessageParametersToAriObject;

/**
 * Class PlaybackContinuingTest
 *
 * @package NgVoice\AriClient\Tests\Model\Message
 */
final class PlaybackContinuingTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var PlaybackContinuing $playbackContinuing
         */
        $playbackContinuing = mapMessageParametersToAriObject(
            'PlaybackContinuing',
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
        $this->assertInstanceOf(Playback::class, $playbackContinuing->getPlayback());
    }
}