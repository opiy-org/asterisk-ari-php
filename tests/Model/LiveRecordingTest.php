<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Model\LiveRecording;
use PHPUnit\Framework\TestCase;
use function NgVoice\AriClient\Tests\mapAriResponseParametersToAriObject;

/**
 * Class LiveRecordingTest
 *
 * @package NgVoice\AriClient\Tests\Model
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
        $liveRecording = mapAriResponseParametersToAriObject(
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