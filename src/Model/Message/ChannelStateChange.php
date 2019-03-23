<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\Model\Message;


use NgVoice\AriClient\Model\Channel;

/**
 * Notification of a channel's state change.
 *
 * @package NgVoice\AriClient\Model\Message
 */
class ChannelStateChange extends Event
{
    /**
     * @var Channel
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