<?php

/** @copyright 2019 ng-voice GmbH */

namespace NgVoice\AriClient\Models\Message;

use NgVoice\AriClient\Models\Endpoint;

/**
 * Endpoint state changed.
 *
 * @package NgVoice\AriClient\Models\Message
 */
final class EndpointStateChange extends Event
{
    /**
     * @var Endpoint
     */
    private $endpoint;

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
