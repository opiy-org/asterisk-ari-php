<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Model\Message\Event;

use NgVoice\AriClient\Model\Playback;

/**
 * Event showing the completion of a media playback operation.
 *
 * @package NgVoice\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class PlaybackFinished extends Event
{
    private Playback $playback;

    /**
     * Playback control object.
     *
     * @return Playback
     */
    public function getPlayback(): Playback
    {
        return $this->playback;
    }
}
