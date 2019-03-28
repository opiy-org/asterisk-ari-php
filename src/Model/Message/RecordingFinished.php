<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\Model\Message;


use NgVoice\AriClient\Model\LiveRecording;

/**
 * Event showing the completion of a recording operation.
 *
 * @package NgVoice\AriClient\Model\Message
 */
class RecordingFinished extends Event
{
    /**
     * @var \NgVoice\AriClient\Model\LiveRecording Recording control object
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