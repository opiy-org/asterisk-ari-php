<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Model\Message\Event;

use NgVoice\AriClient\Model\Playback;

/**
 * Event showing the continuation of a media playback operation
 * from one media URI to the next in the list.
 *
 * @package NgVoice\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class PlaybackContinuing extends Event
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
