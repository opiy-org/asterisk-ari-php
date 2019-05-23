<?php

/** @copyright 2019 ng-voice GmbH */

namespace NgVoice\AriClient\Models\Message;

use NgVoice\AriClient\Models\Channel;

/**
 * A channel initiated a media unhold.
 *
 * @package NgVoice\AriClient\Models\Message
 */
final class ChannelUnhold extends Event
{
    /**
     * @var Channel The channel that initiated the unhold event.
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
