<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\Model\Message;


use AriStasisApp\Model\Channel;

/**
 * Talking was detected on the channel.
 *
 * @package AriStasisApp\Model\Message
 */
class ChannelTalkingStarted extends Event
{
    /**
     * @var Channel The channel on which talking started.
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