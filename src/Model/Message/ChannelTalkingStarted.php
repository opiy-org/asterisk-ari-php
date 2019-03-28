<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\Model\Message;


use NgVoice\AriClient\Model\Channel;

/**
 * Talking was detected on the channel.
 *
 * @package NgVoice\AriClient\Model\Message
 */
class ChannelTalkingStarted extends Event
{
    /**
     * @var \NgVoice\AriClient\Model\Channel The channel on which talking started.
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