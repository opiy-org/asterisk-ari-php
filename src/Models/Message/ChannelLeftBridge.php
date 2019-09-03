<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Models\Message;

use NgVoice\AriClient\Models\{Bridge, Channel};

/**
 * Notification that a channel has left a bridge.
 *
 * @package NgVoice\AriClient\Models\Message
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ChannelLeftBridge extends Event
{
    /**
     * @var Channel
     */
    private $channel;

    /**
     * @var Bridge
     */
    private $bridge;

    /**
     * @return Channel
     */
    public function getChannel(): Channel
    {
        return $this->channel;
    }

    /**
     * @param Channel $channel
     */
    public function setChannel(Channel $channel): void
    {
        $this->channel = $channel;
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
