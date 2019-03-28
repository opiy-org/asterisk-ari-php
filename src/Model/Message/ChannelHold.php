<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\Model\Message;


use NgVoice\AriClient\Model\Channel;

/**
 * A channel initiated a media hold.
 *
 * @package NgVoice\AriClient\Model\Message
 */
class ChannelHold extends Event
{
    /**
     * @var string The music on hold class that the initiator requested.
     */
    private $musicclass;

    /**
     * @var \NgVoice\AriClient\Model\Channel The channel that initiated the hold event.
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