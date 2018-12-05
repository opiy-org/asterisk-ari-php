<?php
/**
 * @author Lukas Stermann
 * @author Rick Barenthin
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
     * Name of this application
     *
     * @var string
     */
    private $name;

    /**
     * Id's for channels subscribed to.
     *
     * @var array
     */
    private $channelIds;

    /**
     * Id's for bridges subscribed to.
     *
     * @var array
     */
    private $bridgeIds;

    /**
     * {tech}/{resource} for endpoints subscribed to.
     *
     * @var array
     */
    private $endpointIds;

    /**
     * Names of the devices subscribed to.
     *
     * @var array
     */
    private $deviceNames;

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
     * @return array
     */
    public function getChannelIds(): array
    {
        return $this->channelIds;
    }

    /**
     * @param array $channelIds
     */
    public function setChannelIds(array $channelIds): void
    {
        $this->channelIds = $channelIds;
    }

    /**
     * @return array
     */
    public function getBridgeIds(): array
    {
        return $this->bridgeIds;
    }

    /**
     * @param array $bridgeIds
     */
    public function setBridgeIds(array $bridgeIds): void
    {
        $this->bridgeIds = $bridgeIds;
    }

    /**
     * @return array
     */
    public function getEndpointIds(): array
    {
        return $this->endpointIds;
    }

    /**
     * @param array $endpointIds
     */
    public function setEndpointIds(array $endpointIds): void
    {
        $this->endpointIds = $endpointIds;
    }

    /**
     * @return array
     */
    public function getDeviceNames(): array
    {
        return $this->deviceNames;
    }

    /**
     * @param array $deviceNames
     */
    public function setDeviceNames(array $deviceNames): void
    {
        $this->deviceNames = $deviceNames;
    }
}