<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model\Message\Event;

use NgVoice\AriClient\Model\LiveRecording;
use NgVoice\AriClient\Model\Message\Event\RecordingStarted;
use NgVoice\AriClient\Tests\Helper;
use NgVoice\AriClient\Tests\Model\LiveRecordingTest;
use PHPUnit\Framework\TestCase;

/**
 * Class RecordingStartedTest
 *
 * @package NgVoice\AriClient\Tests\Model\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class RecordingStartedTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var RecordingStarted $recordingStarted
         */
        $recordingStarted = Helper::mapOntoAriEvent(
            RecordingStarted::class,
            [
                'recording' => LiveRecordingTest::RAW_ARRAY_REPRESENTATION,
            ]
        );
        $this->assertInstanceOf(LiveRecording::class, $recordingStarted->getRecording());
    }
}
