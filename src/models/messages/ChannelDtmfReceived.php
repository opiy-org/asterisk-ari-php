<?php
/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models\messages;


use AriStasisApp\models\Channel;

/**
 * DTMF received on a channel.
 * This event is sent when the DTMF ends. There is no notification about the start of DTMF.
 *
 * @package AriStasisApp\models\messages
 */
class ChannelDtmfReceived extends Event
{
    /**
     * @var int Number of milliseconds DTMF was received.
     */
    private $durationMs;

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
        return $this->durationMs;
    }

    /**
     * @param int $durationMs
     */
    public function setDurationMs(int $durationMs): void
    {
        $this->durationMs = $durationMs;
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