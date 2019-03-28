<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\Model\Message;


use NgVoice\AriClient\Model\Channel;

/**
 * Dialing state has changed.
 *
 * @package NgVoice\AriClient\Model\Message
 */
class Dial extends Event
{
    /**
     * @var \NgVoice\AriClient\Model\Channel Channel that the caller has been forwarded to.
     */
    private $forwarded;

    /**
     * @var \NgVoice\AriClient\Model\Channel The calling channel.
     */
    private $caller;

    /**
     * @var string Current status of the dialing attempt to the peer.
     */
    private $dialstatus;

    /**
     * @var string Forwarding target requested by the original dialed channel.
     */
    private $forward;

    /**
     * @var string The dial string for calling the peer channel.
     */
    private $dialstring;

    /**
     * @var \NgVoice\AriClient\Model\Channel The dialed Channel.
     */
    private $peer;

    /**
     * @return Channel
     */
    public function getForwarded(): Channel
    {
        return $this->forwarded;
    }

    /**
     * @param Channel $forwarded
     */
    public function setForwarded(Channel $forwarded): void
    {
        $this->forwarded = $forwarded;
    }

    /**
     * @return Channel
     */
    public function getCaller(): Channel
    {
        return $this->caller;
    }

    /**
     * @param Channel $caller
     */
    public function setCaller(Channel $caller): void
    {
        $this->caller = $caller;
    }

    /**
     * @return string
     */
    public function getDialstatus(): string
    {
        return $this->dialstatus;
    }

    /**
     * @param string $dialstatus
     */
    public function setDialstatus(string $dialstatus): void
    {
        $this->dialstatus = $dialstatus;
    }

    /**
     * @return string
     */
    public function getForward(): string
    {
        return $this->forward;
    }

    /**
     * @param string $forward
     */
    public function setForward(string $forward): void
    {
        $this->forward = $forward;
    }

    /**
     * @return string
     */
    public function getDialstring(): string
    {
        return $this->dialstring;
    }

    /**
     * @param string $dialstring
     */
    public function setDialstring(string $dialstring): void
    {
        $this->dialstring = $dialstring;
    }

    /**
     * @return Channel
     */
    public function getPeer(): Channel
    {
        return $this->peer;
    }

    /**
     * @param Channel $peer
     */
    public function setPeer(Channel $peer): void
    {
        $this->peer = $peer;
    }
}