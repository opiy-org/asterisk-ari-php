<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\Model;


require_once __DIR__ . '/../../shared_test_functions.php';

use AriStasisApp\Model\{LiveRecording, Message\RecordingStarted};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapMessageParametersToAriObject;

/**
 * Class RecordingStartedTest
 *
 * @package AriStasisApp\Tests\Model\Message
 */
final class RecordingStartedTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
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