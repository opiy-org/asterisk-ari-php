<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model\Message\Event;

use OpiyOrg\AriClient\Model\LiveRecording;
use OpiyOrg\AriClient\Model\Message\Event\RecordingStarted;
use OpiyOrg\AriClient\Tests\Helper;
use OpiyOrg\AriClient\Tests\Model\LiveRecordingTest;
use PHPUnit\Framework\TestCase;

/**
 * Class RecordingStartedTest
 *
 * @package OpiyOrg\AriClient\Tests\Model\Event
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
