<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\Model;


/**
 * An external device that may offer/accept calls to/from Asterisk.
 * Unlike most resources, which have a single unique identifier,
 * an endpoint is uniquely identified by the technology/resource pair.
 *
 * @package NgVoice\AriClient\Model
 */
class Endpoint
{
    /**
     * @var string Identifier of the endpoint, specific to the given technology.
     */
    private $resource;

    /**
     * @var string Endpoint's state ("unknown", "offline", "online").
     */
    private $state;

    /**
     * @var string Technology of the endpoint.
     */
    private $technology;

    /**
     * @var string[] Id's of channels associated with this endpoint.
     */
    private $channel_ids;

    /**
     * @return string
     */
    public function getResource(): string
    {
        return $this->resource;
    }

    /**
     * @param string $resource
     */
    public function setResource(string $resource): void
    {
        $this->resource = $resource;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState(string $state): void
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getTechnology(): string
    {
        return $this->technology;
    }

    /**
     * @param string $technology
     */
    public function setTechnology(string $technology): void
    {
        $this->technology = $technology;
    }

    /**
     * @return string[]
     */
    public function getChannelIds(): array
    {
        return $this->channel_ids;
    }

    /**
     * @param string[] $channelIds
     */
    public function setChannelIds(array $channelIds): void
    {
        $this->channel_ids = $channelIds;
    }
}