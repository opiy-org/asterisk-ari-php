<?php
/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models;


/**
 * Detailed information about a remote peer that communicates with Asterisk.
 *
 * @package AriStasisApp\models
 */
class Peer
{
    /**
     * @var string The current state of the peer.
     * Note that the values of the status are dependent on the underlying peer technology.
     */
    private $peerStatus;

    /**
     * @var string The last known time the peer was contacted.
     */
    private $time;

    /**
     * @var string An optional reason associated with the change in peer_status.
     */
    private $cause;

    /**
     * @var string The port of the peer.
     */
    private $port;

    /**
     * @var string The IP address of the peer.
     */
    private $address;

    /**
     * @return string
     */
    public function getPeerStatus(): string
    {
        return $this->peerStatus;
    }

    /**
     * @param string $peerStatus
     */
    public function setPeerStatus(string $peerStatus): void
    {
        $this->peerStatus = $peerStatus;
    }

    /**
     * @return string
     */
    public function getTime(): string
    {
        return $this->time;
    }

    /**
     * @param string $time
     */
    public function setTime(string $time): void
    {
        $this->time = $time;
    }

    /**
     * @return string
     */
    public function getCause(): string
    {
        return $this->cause;
    }

    /**
     * @param string $cause
     */
    public function setCause(string $cause): void
    {
        $this->cause = $cause;
    }

    /**
     * @return string
     */
    public function getPort(): string
    {
        return $this->port;
    }

    /**
     * @param string $port
     */
    public function setPort(string $port): void
    {
        $this->port = $port;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }
}