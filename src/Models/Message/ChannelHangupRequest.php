<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Models\Message;

use NgVoice\AriClient\Models\Channel;

/**
 * A hangup was requested on the channel.
 *
 * @package NgVoice\AriClient\Models\Message
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ChannelHangupRequest extends Event
{
    /**
     * @var boolean Whether the hangup request was a soft hangup request.
     */
    private $soft;

    /**
     * @var int Integer representation of the cause of the hangup.
     */
    private $cause;

    /**
     * @var Channel The channel on which the hangup was requested.
     */
    private $channel;

    /**
     * @return bool
     */
    public function isSoft(): bool
    {
        return $this->soft;
    }

    /**
     * @param bool $soft
     */
    public function setSoft(bool $soft): void
    {
        $this->soft = $soft;
    }

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
