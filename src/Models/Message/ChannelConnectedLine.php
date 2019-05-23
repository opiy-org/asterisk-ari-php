<?php

/** @copyright 2019 ng-voice GmbH */

namespace NgVoice\AriClient\Models\Message;

use NgVoice\AriClient\Models\Channel;

/**
 * Channel changed Connected Line.
 *
 * @package NgVoice\AriClient\Models\Message
 */
final class ChannelConnectedLine extends Event
{
    /**
     * @var Channel The channel whose connected line has changed.
     */
    private $channel;

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
