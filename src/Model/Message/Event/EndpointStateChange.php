<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model\Message\Event;

use OpiyOrg\AriClient\Model\Endpoint;

/**
 * Endpoint state changed.
 *
 * @package OpiyOrg\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class EndpointStateChange extends Event
{
    private Endpoint $endpoint;

    /**
     * @return Endpoint
     */
    public function getEndpoint(): Endpoint
    {
        return $this->endpoint;
    }
}
