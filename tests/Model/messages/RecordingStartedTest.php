<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Model\{LiveRecording, Message\RecordingStarted};
use PHPUnit\Framework\TestCase;
use function NgVoice\AriClient\Tests\mapMessageParametersToAriObject;

/**
 * Class RecordingStartedTest
 *
 * @package NgVoice\AriClient\Tests\Model\Message
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
        $recordingStarted = mapMessageParametersToAriObject(
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