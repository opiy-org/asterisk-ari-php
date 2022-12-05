<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model;

use OpiyOrg\AriClient\Enum\EndpointStates;

/**
 * An external device that may offer/accept calls to/from Asterisk.
 * Unlike most resources, which have a single unique identifier,
 * an endpoint is uniquely identified by the technology/resource pair.
 *
 * @package OpiyOrg\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class Endpoint implements ModelInterface
{
    public string $resource;

    public ?string $state = null;

    public string $technology;

    /**
     * @var array<int, string>
     */
    public array $channelIds = [];

    /**
     * Identifier of the endpoint, specific to the given technology.
     *
     * @return string
     */
    public function getResource(): string
    {
        return $this->resource;
    }

    /**
     * Endpoint's state.
     *
     * @see EndpointStates
     *
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * Technology of the endpoint.
     *
     * @return string
     */
    public function getTechnology(): string
    {
        return $this->technology;
    }

    /**
     * Id's of channels associated with this endpoint.
     *
     * @return array<int, string>
     */
    public function getChannelIds(): array
    {
        return $this->channelIds;
    }
}
