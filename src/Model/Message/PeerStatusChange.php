<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\Model\Message;


use NgVoice\AriClient\Model\{Endpoint, Peer};

/**
 * The state of a peer associated with an endpoint has changed.
 *
 * @package NgVoice\AriClient\Model\Message
 */
class PeerStatusChange extends Event
{
    /**
     * @var \NgVoice\AriClient\Model\Peer
     */
    private $peer;

    /**
     * @var \NgVoice\AriClient\Model\Endpoint
     */
    private $endpoint;

    /**
     * @return Peer
     */
    public function getPeer(): Peer
    {
        return $this->peer;
    }

    /**
     * @param Peer $peer
     */
    public function setPeer(Peer $peer): void
    {
        $this->peer = $peer;
    }

    /**
     * @return Endpoint
     */
    public function getEndpoint(): Endpoint
    {
        return $this->endpoint;
    }

    /**
     * @param Endpoint $endpoint
     */
    public function setEndpoint(Endpoint $endpoint): void
    {
        $this->endpoint = $endpoint;
    }

}