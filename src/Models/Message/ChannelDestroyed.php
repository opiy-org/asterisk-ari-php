<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Models\Message;

use NgVoice\AriClient\Models\Channel;

/**
 * Notification that a channel has been destroyed.
 *
 * @package NgVoice\AriClient\Models\Message
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ChannelDestroyed extends Event
{
    /**
     * @var int Integer representation of the cause of the hangup.
     */
    private $cause;

    /**
     * @var string Text representation of the cause of the hangup.
     */
    private $cause_txt;

    /**
     * @var Channel
     */
    private $channel;

    /**
     * @return int
     */
    public function getCause(): int
    {
        return $this->cause;
    }

    /**
     * @param int $cause
     */
    public function setCause(int $cause): void
    {
        $this->cause = $cause;
    }

    /**
     * @return string
     */
    public function getCauseTxt(): string
    {
        return $this->cause_txt;
    }

    /**
     * @param string $cause_txt
     */
    public function setCauseTxt(string $cause_txt): void
    {
        $this->cause_txt = $cause_txt;
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
