<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Models\Message;

use NgVoice\AriClient\Models\Channel;

/**
 * A channel initiated a media hold.
 *
 * @package NgVoice\AriClient\Models\Message
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ChannelHold extends Event
{
    /**
     * @var string The music on hold class that the initiator requested.
     */
    private $musicclass;

    /**
     * @var Channel The channel that initiated the hold event.
     */
    private $channel;

    /**
     * @return string
     */
    public function getMusicclass(): string
    {
        return $this->musicclass;
    }

    /**
     * @param string $musicclass
     */
    public function setMusicclass(string $musicclass): void
    {
        $this->musicclass = $musicclass;
    }

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
}
