<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Models\Message;

use NgVoice\AriClient\Models\Channel;

/**
 * Notification that a channel has entered a Stasis application.
 *
 * @package NgVoice\AriClient\Models\Message
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class StasisStart extends Event
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
