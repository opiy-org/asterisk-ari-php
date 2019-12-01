<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models;

use JsonMapper_Exception;
use NgVoice\AriClient\Models\Playback;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class PlaybackTest
 *
 * @package NgVoice\AriClient\Tests\Models
 */
final class PlaybackTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var Playback $playback
         */
        $playback = Helper::mapAriResponseParametersToAriObject(
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
