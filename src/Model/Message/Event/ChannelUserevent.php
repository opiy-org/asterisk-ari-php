<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model\Message\Event;

use OpiyOrg\AriClient\Model\{Bridge, Channel, Endpoint};
use stdClass;

/**
 * User-generated event with additional user-defined fields in the object.
 *
 * @package OpiyOrg\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ChannelUserevent extends Event
{
    private string $eventname;

    private ?Bridge $bridge = null;

    private stdClass $userevent;

    private ?Endpoint $endpoint = null;

    private ?Channel $channel = null;

    /**
     * The name of the user event.
     *
     * @return string
     */
    public function getEventname(): string
    {
        return $this->eventname;
    }

    /**
     * A bridge that is signaled with the user event.
     *
     * @return Bridge|null
     */
    public function getBridge(): ?Bridge
    {
        return $this->bridge;
    }

    /**
     * Custom Userevent data.
     *
     * @return stdClass
     */
    public function getUserevent(): stdClass
    {
        return $this->userevent;
    }

    /**
     * A endpoint that is signaled with the user event.
     *
     * @return Endpoint|null
     */
    public function getEndpoint(): ?Endpoint
    {
        return $this->endpoint;
    }

    /**
     * A channel that is signaled with the user event.
     *
     * @return Channel|null
     */
    public function getChannel(): ?Channel
    {
        return $this->channel;
    }
}
