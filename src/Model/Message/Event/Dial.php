<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Model\Message\Event;

use NgVoice\AriClient\Model\Channel;

/**
 * Dialing state has changed.
 *
 * @package NgVoice\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Dial extends Event
{
    private ?Channel $forwarded = null;

    private ?Channel $caller = null;

    private string $dialstatus;

    private ?string $forward = null;

    private ?string $dialstring = null;

    private Channel $peer;

    /**
     * Channel that the caller has been forwarded to.
     *
     * @return Channel|null
     */
    public function getForwarded(): ?Channel
    {
        return $this->forwarded;
    }

    /**
     * The calling channel.
     *
     * @return Channel|null
     */
    public function getCaller(): ?Channel
    {
        return $this->caller;
    }

    /**
     * Current status of the dialing attempt to the peer.
     *
     * @return string
     */
    public function getDialstatus(): string
    {
        return $this->dialstatus;
    }

    /**
     * Forwarding target requested by the original dialed channel.
     *
     * @return string|null
     */
    public function getForward(): ?string
    {
        return $this->forward;
    }

    /**
     * The dial string for calling the peer channel.
     *
     * @return string|null
     */
    public function getDialstring(): ?string
    {
        return $this->dialstring;
    }

    /**
     * The dialed Channel.
     *
     * @return Channel
     */
    public function getPeer(): Channel
    {
        return $this->peer;
    }
}
