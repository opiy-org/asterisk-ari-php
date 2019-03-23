<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\Model\Message;


use NgVoice\AriClient\Model\Endpoint;

/**
 * Endpoint state changed.
 *
 * @package NgVoice\AriClient\Model\Message
 */
class EndpointStateChange extends Event
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