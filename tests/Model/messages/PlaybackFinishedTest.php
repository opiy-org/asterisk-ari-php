<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\Model;


require_once __DIR__ . '/../../shared_test_functions.php';

use AriStasisApp\Model\{Message\PlaybackFinished, Playback};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapMessageParametersToAriObject;

/**
 * Class PlaybackFinishedTest
 *
 * @package AriStasisApp\Tests\Model\Message
 */
final class PlaybackFinishedTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var PlaybackFinished $playbackFinished
         */
        $playbackFinished = mapMessageParametersToAriObject(
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