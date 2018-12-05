<?php
/**
 * @author Lukas Stermann
 * @author Rick Barenthin
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
     * @var array Arguments to the application TODO List[string]
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
     * @return array
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * @param array $args
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