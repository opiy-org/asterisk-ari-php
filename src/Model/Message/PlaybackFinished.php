<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\Model\Message;


use NgVoice\AriClient\Model\Playback;

/**
 * Event showing the completion of a media playback operation.
 *
 * @package NgVoice\AriClient\Model\Message
 */
class PlaybackFinished extends Event
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