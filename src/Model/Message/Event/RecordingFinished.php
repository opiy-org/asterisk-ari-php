<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model\Message\Event;

use OpiyOrg\AriClient\Model\LiveRecording;

/**
 * Event showing the completion of a recording operation.
 *
 * @package OpiyOrg\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class RecordingFinished extends Event
{
    private LiveRecording $recording;

    /**
     * Recording control object.
     *
     * @return LiveRecording
     */
    public function getRecording(): LiveRecording
    {
        return $this->recording;
    }
}
