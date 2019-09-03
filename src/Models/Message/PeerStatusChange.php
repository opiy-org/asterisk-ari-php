<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Models\Message;

use NgVoice\AriClient\Models\{Endpoint, Peer};

/**
 * The state of a peer associated with an endpoint has changed.
 *
 * @package NgVoice\AriClient\Models\Message
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class PeerStatusChange extends Event
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
