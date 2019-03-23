<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Model\{LiveRecording, Message\RecordingFinished};
use PHPUnit\Framework\TestCase;
use function NgVoice\AriClient\Tests\mapMessageParametersToAriObject;

/**
 * Class RecordingFinishedTest
 *
 * @package NgVoice\AriClient\Tests\Model\Message
 */
final class RecordingFinishedTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var RecordingFinished $recordingFinished
         */
        $recordingFinished = mapMessageParametersToAriObject(
            'RecordingFinished',
            [
                'recording' => [
                    'talking_duration' => '3',
                    'name' => 'ExampleName',
                    'target_uri' => 'ExampleUri',
                    'format' => 'wav',
                    'cause' => 'ExampleCause',
                    'state' => 'paused',
                    'duration' => '4',
                    'silence_duration' => '2'
                ]
            ]
        );
        $this->assertInstanceOf(LiveRecording::class, $recordingFinished->getRecording());
    }
}