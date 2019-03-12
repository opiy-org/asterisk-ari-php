<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\Model\Message;


use AriStasisApp\Model\Bridge;
use AriStasisApp\Model\Channel;

/**
 * Notification that a channel has left a bridge.
 *
 * @package AriStasisApp\Model\Message
 */
class ChannelLeftBridge extends Event
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