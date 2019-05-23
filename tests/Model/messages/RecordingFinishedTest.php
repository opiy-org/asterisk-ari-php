<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Models\{LiveRecording, Message\RecordingFinished};
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class RecordingFinishedTest
 *
 * @package NgVoice\AriClient\Tests\Models\Message
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
        $recordingFinished = Helper::mapMessageParametersToAriObject(
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
