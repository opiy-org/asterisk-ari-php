<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\Model\Message;


use NgVoice\AriClient\Model\Channel;

/**
 * DTMF received on a channel.
 * This event is sent when the DTMF ends. There is no notification about the start of DTMF.
 *
 * @package NgVoice\AriClient\Model\Message
 */
class ChannelDtmfReceived extends Event
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
     * @var \NgVoice\AriClient\Model\Channel The channel on which DTMF was received.
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