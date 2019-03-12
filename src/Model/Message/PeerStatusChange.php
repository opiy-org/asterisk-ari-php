<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\Model\Message;


use AriStasisApp\Model\Endpoint;
use AriStasisApp\Model\Peer;

/**
 * The state of a peer associated with an endpoint has changed.
 *
 * @package AriStasisApp\Model\Message
 */
class PeerStatusChange extends Event
{
    /**
     * @var Peer
     */
    private $peer;

    /**
     * @var Endpoint
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