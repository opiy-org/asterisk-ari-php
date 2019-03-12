<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\Model;


require_once __DIR__ . '/../shared_test_functions.php';

use AriStasisApp\Model\{Playback};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapAriResponseParametersToAriObject;

/**
 * Class PlaybackTest
 *
 * @package AriStasisApp\Tests\Model
 */
final class PlaybackTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var Playback $playback
         */
        $playback = mapAriResponseParametersToAriObject(
            'Playback',
            [
                'next_media_uri' => 'ExampleUri',
                'target_uri' => 'ExampleTargetUri',
                'language' => 'en',
                'state' => 'queued',
                'media_uri' => 'ExampleMediaRui',
                'id' => 'ExampleId'
            ]
        );
        $this->assertSame('ExampleTargetUri', $playback->getTargetUri());
        $this->assertSame('queued', $playback->getState());
        $this->assertSame('en', $playback->getLanguage());
        $this->assertSame('ExampleId', $playback->getId());
        $this->assertSame('ExampleMediaRui', $playback->getMediaUri());
        $this->assertSame('ExampleUri', $playback->getNextMediaUri());
    }
}