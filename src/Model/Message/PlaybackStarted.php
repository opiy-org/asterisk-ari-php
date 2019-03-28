<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\Model\Message;


use NgVoice\AriClient\Model\Playback;

/**
 * Event showing the start of a media playback operation.
 *
 * @package NgVoice\AriClient\Model\Message
 */
class PlaybackStarted extends Event
{
    /**
     * @var \NgVoice\AriClient\Model\Playback Playback control object.
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