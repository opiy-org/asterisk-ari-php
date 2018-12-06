<?php

/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models\messages;


use AriStasisApp\models\Channel;

/**
 * Talking is no longer detected on the channel.
 *
 * @package AriStasisApp\models\messages
 */
class ChannelTalkingFinished extends Event
{
    /**
     * @var int The length of time, in milliseconds, that talking was detected on the channel
     */
    private $duration;

    /**
     * @var Channel The channel on which talking completed.
     */
    private $channel;

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     */
    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
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