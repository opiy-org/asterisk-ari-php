<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models\messages;


use AriStasisApp\models\Channel;

/**
 * A channel initiated a media unhold.
 *
 * @package AriStasisApp\models\messages
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