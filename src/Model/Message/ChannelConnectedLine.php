<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\Model\Message;


use NgVoice\AriClient\Model\Channel;

/**
 * Channel changed Connected Line.
 *
 * @package NgVoice\AriClient\Model\Message
 */
class ChannelConnectedLine extends Event
{
    /**
     * @var \NgVoice\AriClient\Model\Channel The channel whose connected line has changed.
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