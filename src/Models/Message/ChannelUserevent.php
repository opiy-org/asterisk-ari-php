<?php

/** @copyright 2019 ng-voice GmbH */

namespace NgVoice\AriClient\Models\Message;

use NgVoice\AriClient\Models\{Bridge, Channel, Endpoint};

/**
 * User-generated event with additional user-defined fields in the object.
 *
 * @package NgVoice\AriClient\Models\Message
 */
final class ChannelUserevent extends Event
{
    /**
     * @var string The name of the user event.
     */
    private $eventname;

    /**
     * @var Bridge A bridge that is signaled with the user event.
     */
    private $bridge;

    /**
     * @var object Custom Userevent data
     */
    private $userevent;

    /**
     * @var Endpoint A endpoint that is signaled with the user event.
     */
    private $endpoint;

    /**
     * @var Channel A channel that is signaled with the user event.
     */
    private $channel;

    /**
     * @return string
     */
    public function getEventname(): string
    {
        return $this->eventname;
    }

    /**
     * @param string $eventname
     */
    public function setEventname(string $eventname): void
    {
        $this->eventname = $eventname;
    }

    /**
     * @return Bridge
     */
    public function getBridge(): Bridge
    {
        return $this->bridge;
    }

    /**
     * @param Bridge $bridge
     */
    public function setBridge(Bridge $bridge): void
    {
        $this->bridge = $bridge;
    }

    /**
     * @return object
     */
    public function getUserevent(): object
    {
        return $this->userevent;
    }

    /**
     * @param object $userevent
     */
    public function setUserevent(object $userevent): void
    {
        $this->userevent = $userevent;
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

    /**
     * @return Channel
     */
    public function getChannel(): Channel
    {
        return $this->channel;
    }

    /**
     * @param Channel $channel
     */
    public function setChannel(Channel $channel): void
    {
        $this->channel = $channel;
    }
}
