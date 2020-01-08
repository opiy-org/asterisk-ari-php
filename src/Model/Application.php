<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Model;

use NgVoice\AriClient\Model\Message\Message;

/**
 * Details of a Stasis application.
 *
 * @package NgVoice\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Application implements ModelInterface
{
    private string $name;

    /**
     * @var array<int, string>
     */
    private array $endpointIds = [];

    /**
     * @var array<int, string>
     */
    private array $channelIds = [];

    /**
     * @var array<int, string>
     */
    private array $deviceNames = [];

    /**
     * @var array<int, Message>
     */
    private array $eventsDisallowed = [];

    /**
     * @var array<int, string>
     */
    private array $bridgeIds = [];

    /**
     * @var array<int, Message>
     */
    private array $eventsAllowed = [];

    /**
     * Get the name of this application.
     *
     * @return string The name of this application
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the {tech}/{resource} for endpoints subscribed to.
     *
     * @return array<int, string>
     */
    public function getEndpointIds(): array
    {
        return $this->endpointIds;
    }

    /**
     * Get the id's for channels subscribed to.
     *
     * @return array<int, string>
     */
    public function getChannelIds(): array
    {
        return $this->channelIds;
    }

    /**
     * Get the names of the devices subscribed to.
     *
     * @return array<int, string>
     */
    public function getDeviceNames(): array
    {
        return $this->deviceNames;
    }

    /**
     * Get the event types not sent to the application.
     *
     * @return array<int, Message>
     */
    public function getEventsDisallowed(): array
    {
        return $this->eventsDisallowed;
    }

    /**
     * Get the id's for bridges subscribed to.
     *
     * @return array<int, string>
     */
    public function getBridgeIds(): array
    {
        return $this->bridgeIds;
    }

    /**
     * Get the event types sent to the application.
     *
     * @return array<int, Message>
     */
    public function getEventsAllowed(): array
    {
        return $this->eventsAllowed;
    }
}
