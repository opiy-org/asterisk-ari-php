<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\Model\Message;


use AriStasisApp\Model\Channel;

/**
 * Notification that a channel has entered a Stasis application.
 *
 * @package AriStasisApp\Model\Message
 */
class StasisStart extends Event
{
    /**
     * @var string[] Arguments to the application.
     */
    private $args;

    /**
     * @var Channel
     */
    private $replace_channel;

    /**
     * @var Channel
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