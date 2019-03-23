<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\Model;


use NgVoice\AriClient\Model\Message\Message;

/**
 * Details of a Stasis application"
 *
 * @package NgVoice\AriClient\Model
 */
class Application
{
    /**
     * @var string Name of this application
     */
    private $name;

    /**
     * @var string[] {tech}/{resource} for endpoints subscribed to.
     */
    private $endpoint_ids;

    /**
     * @var string[] Id's for channels subscribed to.
     */
    private $channel_ids;

    /**
     * @var string[] Names of the devices subscribed to.
     */
    private $device_names;

    /**
     * @var Message[] Event types not sent to the application.
     */
    private $events_disallowed;

    /**
     * @var string[] Id's for bridges subscribed to.
     */
    private $bridge_ids;

    /**
     * @var Message[] Event types sent to the application.
     */
    private $events_allowed;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string[]
     */
    public function getEndpointIds(): array
    {
        return $this->endpoint_ids;
    }

    /**
     * @param string[] $endpoint_ids
     */
    public function setEndpointIds(array $endpoint_ids): void
    {
        $this->endpoint_ids = $endpoint_ids;
    }

    /**
     * @return string[]
     */
    public function getChannelIds(): array
    {
        return $this->channel_ids;
    }

    /**
     * @param string[] $channel_ids
     */
    public function setChannelIds(array $channel_ids): void
    {
        $this->channel_ids = $channel_ids;
    }

    /**
     * @return string[]
     */
    public function getDeviceNames(): array
    {
        return $this->device_names;
    }

    /**
     * @param string[] $device_names
     */
    public function setDeviceNames(array $device_names): void
    {
        $this->device_names = $device_names;
    }

    /**
     * @return Message[]
     */
    public function getEventsDisallowed(): array
    {
        return $this->events_disallowed;
    }

    /**
     * @param Message[] $events_disallowed
     */
    public function setEventsDisallowed(array $events_disallowed): void
    {
        $this->events_disallowed = $events_disallowed;
    }

    /**
     * @return string[]
     */
    public function getBridgeIds(): array
    {
        return $this->bridge_ids;
    }

    /**
     * @param string[] $bridge_ids
     */
    public function setBridgeIds(array $bridge_ids): void
    {
        $this->bridge_ids = $bridge_ids;
    }

    /**
     * @return Message[]
     */
    public function getEventsAllowed(): array
    {
        return $this->events_allowed;
    }

    /**
     * @param Message[] $events_allowed
     */
    public function setEventsAllowed(array $events_allowed): void
    {
        $this->events_allowed = $events_allowed;
    }
}