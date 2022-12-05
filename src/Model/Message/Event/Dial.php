<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model\Message\Event;

use OpiyOrg\AriClient\Model\Channel;

/**
 * Dialing state has changed.
 *
 * @package OpiyOrg\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class Dial extends Event
{
    public ?Channel $forwarded = null;

    public ?Channel $caller = null;

    public string $dialstatus;

    public ?string $forward = null;

    public ?string $dialstring = null;

    public Channel $peer;

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
