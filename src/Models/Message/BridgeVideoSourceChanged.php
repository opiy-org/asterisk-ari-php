<?php

/** @copyright 2019 ng-voice GmbH */

namespace NgVoice\AriClient\Models\Message;

use NgVoice\AriClient\Models\Bridge;

/**
 * Notification that the source of video in a bridge has changed.
 *
 * @package NgVoice\AriClient\Models\Message
 */
final class BridgeVideoSourceChanged extends Event
{
    /**
     * @var string
     */
    private $old_video_source_id;

    /**
     * @var Bridge
     */
    private $bridge;

    /**
     * @return string
     */
    public function getOldVideoSourceId(): string
    {
        return $this->old_video_source_id;
    }

    /**
     * @param string $old_video_source_id
     */
    public function setOldVideoSourceId(string $old_video_source_id): void
    {
        $this->old_video_source_id = $old_video_source_id;
    }

    /**
     * @return Bridge
     */
    public function getBridge(): Bridge
    {
        return $this->bridge;
    }

    /**
     * @param Bridge $bridge
     */
    public function setBridge(Bridge $bridge): void
    {
        $this->bridge = $bridge;
    }
}
