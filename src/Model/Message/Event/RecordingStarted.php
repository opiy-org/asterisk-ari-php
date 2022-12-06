<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model\Message\Event;

use OpiyOrg\AriClient\Model\LiveRecording;

/**
 * Event showing the start of a recording operation.
 *
 * @package OpiyOrg\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class RecordingStarted extends Event
{
    public LiveRecording $recording;

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
