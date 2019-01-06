<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models;


/**
 * Details of a Stasis application"
 *
 * @package AriStasisApp\models
 */
class Application
{
    /**
     * @var string[] {tech}/{resource} for endpoints subscribed to.
     * @required
     */
    private $endpoint_ids;

    /**
     * @var string[] Id's for channels subscribed to.
     * @required
     */
    private $channel_ids;

    /**
     * @var string[] Id's for bridges subscribed to.
     * @required
     */
    private $bridge_ids;

    /**
     * @var string[] Names of the devices subscribed to.
     * @required
     */
    private $device_names;

    /**
     * @var string Name of this application
     * @required
     */
    private $name;

    /**
     * @return string[]
     */
    public function getEndpointIds(): array
    {
        return $this->endpoint_ids;
    }

    /**
     * @param string[] $endpointIds
     */
    public function setEndpointIds(array $endpointIds): void
    {
        $this->endpoint_ids = $endpointIds;
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

    /**
     * @return string[]
     */
    public function getBridgeIds(): array
    {
        return $this->bridge_ids;
    }

    /**
     * @param string[] $bridgeIds
     */
    public function setBridgeIds(array $bridgeIds): void
    {
        $this->bridge_ids = $bridgeIds;
    }

    /**
     * @return string[]
     */
    public function getDeviceNames(): array
    {
        return $this->device_names;
    }

    /**
     * @param string[] $deviceNames
     */
    public function setDeviceNames(array $deviceNames): void
    {
        $this->device_names = $deviceNames;
    }

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
}