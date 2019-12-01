<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models;

use JsonMapper_Exception;
use NgVoice\AriClient\Models\LiveRecording;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class LiveRecordingTest
 *
 * @package NgVoice\AriClient\Tests\Models
 */
final class LiveRecordingTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var LiveRecording $liveRecording
         */
        $liveRecording = Helper::mapAriResponseParametersToAriObject(
            'LiveRecording',
            [
                'talking_duration' => '3',
                'name' => 'ExampleName',
                'target_uri' => 'ExampleUri',
                'format' => 'wav',
                'cause' => 'ExampleCause',
                'state' => 'paused',
                'duration' => '4',
                'silence_duration' => '2'
            ]
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
