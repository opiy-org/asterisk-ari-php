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
    private $endpointIds;

    /**
     * @var string[] Id's for channels subscribed to.
     * @required
     */
    private $channelIds;

    /**
     * @var string[] Id's for bridges subscribed to.
     * @required
     */
    private $bridgeIds;

    /**
     * @var string[] Names of the devices subscribed to.
     * @required
     */
    private $deviceNames;

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
        return $this->endpointIds;
    }

    /**
     * @param string[] $endpointIds
     */
    public function setEndpointIds(array $endpointIds): void
    {
        $this->endpointIds = $endpointIds;
    }

    /**
     * @return string[]
     */
    public function getChannelIds(): array
    {
        return $this->channelIds;
    }

    /**
     * @param string[] $channelIds
     */
    public function setChannelIds(array $channelIds): void
    {
        $this->channelIds = $channelIds;
    }

    /**
     * @return string[]
     */
    public function getBridgeIds(): array
    {
        return $this->bridgeIds;
    }

    /**
     * @param string[] $bridgeIds
     */
    public function setBridgeIds(array $bridgeIds): void
    {
        $this->bridgeIds = $bridgeIds;
    }

    /**
     * @return string[]
     */
    public function getDeviceNames(): array
    {
        return $this->deviceNames;
    }

    /**
     * @param string[] $deviceNames
     */
    public function setDeviceNames(array $deviceNames): void
    {
        $this->deviceNames = $deviceNames;
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