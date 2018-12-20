<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models\messages;


use AriStasisApp\models\Channel;

/**
 * Notification that a channel has entered a Stasis application.
 *
 * @package AriStasisApp\models\messages
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
    private $replaceChannel;

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
        return $this->replaceChannel;
    }

    /**
     * @param Channel $replaceChannel
     */
    public function setReplaceChannel(Channel $replaceChannel): void
    {
        $this->replaceChannel = $replaceChannel;
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