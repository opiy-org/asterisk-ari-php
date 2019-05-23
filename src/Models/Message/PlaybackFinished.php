<?php

/** @copyright 2019 ng-voice GmbH */

namespace NgVoice\AriClient\Models\Message;

use NgVoice\AriClient\Models\Playback;

/**
 * Event showing the completion of a media playback operation.
 *
 * @package NgVoice\AriClient\Models\Message
 */
final class PlaybackFinished extends Event
{
    /**
     * @var Playback Playback control object.
     */
    private $playback;

    /**
     * @return Playback
     */
    public function getPlayback(): Playback
    {
        return $this->playback;
    }

    /**
     * @param Playback $playback
     */
    public function setPlayback(Playback $playback): void
    {
        $this->playback = $playback;
    }
}
