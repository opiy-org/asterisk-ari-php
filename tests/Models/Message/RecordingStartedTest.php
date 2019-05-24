<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models\Message;


use JsonMapper_Exception;
use NgVoice\AriClient\Models\{LiveRecording, Message\RecordingStarted};
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class RecordingStartedTest
 *
 * @package NgVoice\AriClient\Tests\Models\Message
 */
final class RecordingStartedTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var RecordingStarted $recordingStarted
         */
        $recordingStarted = Helper::mapMessageParametersToAriObject(
            'RecordingStarted',
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
        $this->assertInstanceOf(LiveRecording::class, $recordingStarted->getRecording());
    }
}
