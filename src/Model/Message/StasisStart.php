<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\Model\Message;


use NgVoice\AriClient\Model\Channel;

/**
 * Notification that a channel has entered a Stasis application.
 *
 * @package NgVoice\AriClient\Model\Message
 */
class StasisStart extends Event
{
    /**
     * @var string[] Arguments to the application.
     */
    private $args;

    /**
     * @var \NgVoice\AriClient\Model\Channel
     */
    private $replace_channel;

    /**
     * @var \NgVoice\AriClient\Model\Channel
     */
    private $channel;

    /**
     * @return string[]
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * @param string[] $args
     */
    public function setArgs(array $args): void
    {
        $this->args = $args;
    }

    /**
     * @return Channel
     */
    public function getReplaceChannel(): Channel
    {
        return $this->replace_channel;
    }

    /**
     * @param Channel $replaceChannel
     */
    public function setReplaceChannel(Channel $replaceChannel): void
    {
        $this->replace_channel = $replaceChannel;
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