<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model;

/**
 * The merging of media from one or more channels.
 *
 * Everyone on the bridge receives the same audio.
 *
 * @package OpiyOrg\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class Bridge implements ModelInterface
{
    public string $bridgeType;

    public string $name;

    public string $creator;

    public ?string $videoMode = null;

    public string $creationtime;

    /**
     * @var array<int, string>
     */
    public array $channels = [];

    public ?string $videoSourceId = null;

    public string $bridgeClass;

    public string $technology;

    public string $id;

    /**
     * Type of bridge technology (mixing | holding).
     *
     * @return string
     */
    public function getBridgeType(): string
    {
        return $this->bridgeType;
    }

    /**
     * Name the creator gave the bridge.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Entity that created the bridge.
     *
     * @return string
     */
    public function getCreator(): string
    {
        return $this->creator;
    }

    /**
     * The video mode the bridge is using.
     *
     * One of 'none', 'talker', or 'single'.
     *
     * @return string|null
     */
    public function getVideoMode(): ?string
    {
        return $this->videoMode;
    }

    /**
     * Timestamp when bridge was created.
     *
     * @return string
     */
    public function getCreationtime(): string
    {
        return $this->creationtime;
    }

    /**
     * Ids of channels participating in this bridge.
     *
     * @return array<int, string>
     */
    public function getChannels(): array
    {
        return $this->channels;
    }

    /**
     * The ID of the channel that is the source of
     * video in this bridge, if one exists.
     *
     * @return string|null
     */
    public function getVideoSourceId(): ?string
    {
        return $this->videoSourceId;
    }

    /**
     * Bridging class.
     *
     * @return string
     */
    public function getBridgeClass(): string
    {
        return $this->bridgeClass;
    }

    /**
     * Name of the current bridging technology.
     *
     * @return string
     */
    public function getTechnology(): string
    {
        return $this->technology;
    }

    /**
     * Unique identifier for this bridge.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}
