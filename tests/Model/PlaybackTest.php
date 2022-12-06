<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model;

use OpiyOrg\AriClient\Model\Playback;
use OpiyOrg\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class PlaybackTest
 *
 * @package OpiyOrg\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class PlaybackTest extends TestCase
{
    public const RAW_ARRAY_REPRESENTATION = [
        'next_media_uri' => 'ExampleUri',
        'target_uri' => 'ExampleTargetUri',
        'language' => 'en',
        'state' => 'queued',
        'media_uri' => 'ExampleMediaRui',
        'id' => 'ExampleId',
    ];

    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var Playback $playback
         */
        $playback = Helper::mapOntoInstance(
            self::RAW_ARRAY_REPRESENTATION,
            new Playback()
        );
        $this->assertSame('ExampleTargetUri', $playback->getTargetUri());
        $this->assertSame('queued', $playback->getState());
        $this->assertSame('en', $playback->getLanguage());
        $this->assertSame('ExampleId', $playback->getId());
        $this->assertSame('ExampleMediaRui', $playback->getMediaUri());
        $this->assertSame('ExampleUri', $playback->getNextMediaUri());
    }
}
