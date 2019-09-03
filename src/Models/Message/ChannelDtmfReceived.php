<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Models\Message;

use NgVoice\AriClient\Models\Channel;

/**
 * DTMF received on a channel.
 * This event is sent when the DTMF ends. There is no notification about the start of DTMF.
 *
 * @package NgVoice\AriClient\Models\Message
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ChannelDtmfReceived extends Event
{
    /**
     * @var int Number of milliseconds DTMF was received.
     */
    private $duration_ms;

    /**
     * @var string DTMF digit received (0-9, A-E, # or *).
     */
    private $digit;

    /**
     * @var Channel The channel on which DTMF was received.
     */
    private $channel;

    /**
     * @return int
     */
    public function getDurationMs(): int
    {
        return $this->duration_ms;
    }

    /**
     * @param int $durationMs
     */
    public function setDurationMs(int $durationMs): void
    {
        $this->duration_ms = $durationMs;
    }

    /**
     * @return string
     */
    public function getDigit(): string
    {
        return $this->digit;
    }

    /**
     * @param string $digit
     */
    public function setDigit(string $digit): void
    {
        $this->digit = $digit;
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
