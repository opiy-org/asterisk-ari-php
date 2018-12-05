<?php
/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models\messages;


use AriStasisApp\models\LiveRecording;

/**
 * Event showing the completion of a recording operation.
 *
 * @package AriStasisApp\models\messages
 */
class RecordingFinished extends Event
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