<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model\Message\Event;

use OpiyOrg\AriClient\Model\{Endpoint, Peer};

/**
 * The state of a peer associated with an endpoint has changed.
 *
 * @package OpiyOrg\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class PeerStatusChange extends Event
{
    private Peer $peer;

    private Endpoint $endpoint;

    /**
     * @return Peer
     */
    public function getPeer(): Peer
    {
        return $this->peer;
    }

    /**
     * @return Endpoint
     */
    public function getEndpoint(): Endpoint
    {
        return $this->endpoint;
    }
}
