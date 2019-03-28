<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\Model\Message;


use NgVoice\AriClient\Model\{Bridge, Channel};

/**
 * Notification that a channel has entered a bridge.
 *
 * @package NgVoice\AriClient\Model\Message
 */
class ChannelEnteredBridge extends Event
{
    /**
     * @var \NgVoice\AriClient\Model\Channel
     */
    private $channel;

    /**
     * @var \NgVoice\AriClient\Model\Bridge
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