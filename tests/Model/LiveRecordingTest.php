<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model;

use OpiyOrg\AriClient\Model\LiveRecording;
use OpiyOrg\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class LiveRecordingTest
 *
 * @package OpiyOrg\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class LiveRecordingTest extends TestCase
{
    public const RAW_ARRAY_REPRESENTATION = [
        'talking_duration' => 3,
        'name'             => 'ExampleName',
        'target_uri'       => 'ExampleUri',
        'format'           => 'wav',
        'cause'            => 'ExampleCause',
        'state'            => 'paused',
        'duration'         => 4,
        'silence_duration' => 2,
    ];

    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var LiveRecording $liveRecording
         */
        $liveRecording = Helper::mapOntoInstance(
            self::RAW_ARRAY_REPRESENTATION,
            new LiveRecording()
        );
        $this->assertSame('wav', $liveRecording->getFormat());
        $this->assertSame('paused', $liveRecording->getState());
        $this->assertSame('ExampleName', $liveRecording->getName());
        $this->assertSame('ExampleCause', $liveRecording->getCause());
        $this->assertSame(4, $liveRecording->getDuration());
        $this->assertSame(2, $liveRecording->getSilenceDuration());
        $this->assertSame(3, $liveRecording->getTalkingDuration());
        $this->assertSame('ExampleUri', $liveRecording->getTargetUri());
    }
}
