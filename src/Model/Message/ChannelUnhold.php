<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\Model\Message;


use AriStasisApp\Model\Channel;

/**
 * A channel initiated a media unhold.
 *
 * @package AriStasisApp\Model\Message
 */
class ChannelUnhold extends Event
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