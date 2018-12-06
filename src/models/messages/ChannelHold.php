<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models\messages;


use AriStasisApp\models\Channel;

/**
 * A channel initiated a media hold.
 *
 * @package AriStasisApp\models\messages
 */
class ChannelHold extends Event
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