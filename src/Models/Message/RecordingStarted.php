<?php

/** @copyright 2019 ng-voice GmbH */

namespace NgVoice\AriClient\Models\Message;

use NgVoice\AriClient\Models\LiveRecording;

/**
 * Event showing the start of a recording operation.
 *
 * @package NgVoice\AriClient\Models\Message
 */
final class RecordingStarted extends Event
{
    /**
     * @var LiveRecording Recording control object
     */
    private $recording;

    /**
     * @return LiveRecording
     */
    public function getRecording(): LiveRecording
    {
        return $this->recording;
    }

    /**
     * @param LiveRecording $recording
     */
    public function setRecording(LiveRecording $recording): void
    {
        $this->recording = $recording;
    }
}
