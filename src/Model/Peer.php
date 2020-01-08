<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Model;

/**
 * Detailed information about a remote peer that communicates with Asterisk.
 *
 * @package NgVoice\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Peer implements ModelInterface
{
    private string $peerStatus;

    private ?string $time = null;

    private ?string $cause = null;

    private ?string $port = null;

    private ?string $address = null;

    /**
     * The current state of the peer.
     *
     * Note that the values of the status are dependent on the underlying peer technology.
     *
     * @return string
     */
    public function getPeerStatus(): string
    {
        return $this->peerStatus;
    }

    /**
     * The last known time the peer was contacted.
     *
     * @return string|null
     */
    public function getTime(): ?string
    {
        return $this->time;
    }

    /**
     * An optional reason associated with the change in $peerStatus.
     *
     * @return string|null
     */
    public function getCause(): ?string
    {
        return $this->cause;
    }

    /**
     * The port of the peer.
     *
     * @return string|null
     */
    public function getPort(): ?string
    {
        return $this->port;
    }

    /**
     * The IP address of the peer.
     *
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }
}
