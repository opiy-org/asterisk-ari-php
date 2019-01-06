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
     * @var string Type of bridge technology (mixing | holding).
     * @required
     */
    private $bridge_type;

    /**
     * @var string Name the creator gave the bridge
     * @required
     */
    private $name;

    /**
     * @var string Entity that created the bridge.
     * @required
     */
    private $creator;

    /**
     * @var string The video mode the bridge is using. One of 'none', 'talker', or 'single'.
     */
    private $video_mode;

    /**
     * @var string[] Ids of channels participating in this bridge
     * @required
     */
    private $channels;

    /**
     * @var string The ID of the channel that is the source of video in this bridge, if one exists.
     */
    private $video_source_id;

    /**
     * @var string Bridging class.
     * @required
     */
    private $bridge_class;

    /**
     * @var string Name of the current bridging technology.
     * @required
     */
    private $technology;

    /**
     * @var string Unique identifier for this bridge.
     * @required
     */
    private $id;

    /**
     * @return string
     */
    public function getBridgeType(): string
    {
        return $this->bridge_type;
    }

    /**
     * @param string $bridgeType
     */
    public function setBridgeType(string $bridgeType): void
    {
        $this->bridge_type = $bridgeType;
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
    public function getVideoMode(): string
    {
        return $this->video_mode;
    }

    /**
     * @param string $videoMode
     */
    public function setVideoMode(string $videoMode): void
    {
        $this->video_mode = $videoMode;
    }

    /**
     * @return string[]
     */
    public function getChannels(): array
    {
        return $this->channels;
    }

    /**
     * @param string[] $channels
     */
    public function setChannels(array $channels): void
    {
        $this->channels = $channels;
    }

    /**
     * @return string
     */
    public function getVideoSourceId(): string
    {
        return $this->video_source_id;
    }

    /**
     * @param string $videoSourceId
     */
    public function setVideoSourceId(string $videoSourceId): void
    {
        $this->video_source_id = $videoSourceId;
    }

    /**
     * @return string
     */
    public function getBridgeClass(): string
    {
        return $this->bridge_class;
    }

    /**
     * @param string $bridgeClass
     */
    public function setBridgeClass(string $bridgeClass): void
    {
        $this->bridge_class = $bridgeClass;
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
}