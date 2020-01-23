<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Model;

use NgVoice\AriClient\Enum\EndpointStates;

/**
 * An external device that may offer/accept calls to/from Asterisk.
 * Unlike most resources, which have a single unique identifier,
 * an endpoint is uniquely identified by the technology/resource pair.
 *
 * @package NgVoice\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Endpoint implements ModelInterface
{
    private string $resource;

    private ?string $state = null;

    private string $technology;

    /**
     * @var array<int, string>
     */
    private array $channelIds = [];

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
