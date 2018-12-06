<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models;


/**
 * The merging of media from one or more channels. Everyone on the bridge receives the same audio.
 *
 * @package AriStasisApp\models
 */
class Bridge
{
    /**
     * @var string Unique identifier for this bridge.
     */
    private $id;

    /**
     * @var string Name of the current bridging technology.
     */
    private $technology;

    /**
     * @var string Type of bridge technology (mixing | holding).
     */
    private $bridgeType;

    /**
     * @var string Bridging class.
     */
    private $bridgeClass;

    /**
     * @var string Entity that created the bridge.
     */
    private $creator;

    /**
     * @var string Name the creator gave the bridge
     */
    private $name;

    /**
     * @var array Ids of channels participating in this bridge
     */
    private $channels;

    /**
     * @var string The video mode the bridge is using. One of 'none', 'talker', or 'single'.
     */
    private $videoMode;

    /**
     * @var string The ID of the channel that is the source of video in this bridge, if one exists.
     */
    private $videoSourceId;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
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
     * @return string
     */
    public function getBridgeType(): string
    {
        return $this->bridgeType;
    }

    /**
     * @param string $bridgeType
     */
    public function setBridgeType(string $bridgeType): void
    {
        $this->bridgeType = $bridgeType;
    }

    /**
     * @return string
     */
    public function getBridgeClass(): string
    {
        return $this->bridgeClass;
    }

    /**
     * @param string $bridgeClass
     */
    public function setBridgeClass(string $bridgeClass): void
    {
        $this->bridgeClass = $bridgeClass;
    }

    /**
     * @return string
     */
    public function getCreator(): string
    {
        return $this->creator;
    }

    /**
     * @param string $creator
     */
    public function setCreator(string $creator): void
    {
        $this->creator = $creator;
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

    /**
     * @return array
     */
    public function getChannels(): array
    {
        return $this->channels;
    }

    /**
     * @param array $channels
     */
    public function setChannels(array $channels): void
    {
        $this->channels = $channels;
    }

    /**
     * @return string
     */
    public function getVideoMode(): string
    {
        return $this->videoMode;
    }

    /**
     * @param string $videoMode
     */
    public function setVideoMode(string $videoMode): void
    {
        $this->videoMode = $videoMode;
    }

    /**
     * @return string
     */
    public function getVideoSourceId(): string
    {
        return $this->videoSourceId;
    }

    /**
     * @param string $videoSourceId
     */
    public function setVideoSourceId(string $videoSourceId): void
    {
        $this->videoSourceId = $videoSourceId;
    }
}