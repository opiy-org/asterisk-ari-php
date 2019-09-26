<?php

/**
 * The JSONMapper library needs the full name path of
 * a class, so there are no imports used instead.
 *
 * @noinspection PhpFullyQualifiedNameUsageInspection
 */

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Models;

/**
 * The merging of media from one or more channels.
 * Everyone on the bridge receives the same audio.
 *
 * @package NgVoice\AriClient\Models
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Bridge implements ModelInterface
{
    /**
     * Type of bridge technology (mixing | holding).
     *
     * @var string
     */
    private $bridge_type;

    /**
     * @var string Name the creator gave the bridge
     */
    private $name;

    /**
     * @var string Entity that created the bridge.
     */
    private $creator;

    /**
     * @var string The video mode the bridge is using.
     * One of 'none', 'talker', or 'single'.
     */
    private $video_mode;

    /**
     * @var string Timestamp when bridge was created
     */
    private $creationtime;

    /**
     * @var string[] Ids of channels participating in this bridge
     */
    private $channels;

    /**
     * @var string The ID of the channel that is the source of video in this bridge, if
     *     one exists.
     */
    private $video_source_id;

    /**
     * @var string Bridging class.
     */
    private $bridge_class;

    /**
     * @var string Name of the current bridging technology.
     */
    private $technology;

    /**
     * @var string Unique identifier for this bridge.
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
     * @param string $bridge_type
     */
    public function setBridgeType(string $bridge_type): void
    {
        $this->bridge_type = $bridge_type;
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
     * @param string $video_mode
     */
    public function setVideoMode(string $video_mode): void
    {
        $this->video_mode = $video_mode;
    }

    /**
     * @return string
     */
    public function getCreationtime(): string
    {
        return $this->creationtime;
    }

    /**
     * @param string $creationtime
     */
    public function setCreationtime(string $creationtime): void
    {
        $this->creationtime = $creationtime;
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
     * @param string $video_source_id
     */
    public function setVideoSourceId(string $video_source_id): void
    {
        $this->video_source_id = $video_source_id;
    }

    /**
     * @return string
     */
    public function getBridgeClass(): string
    {
        return $this->bridge_class;
    }

    /**
     * @param string $bridge_class
     */
    public function setBridgeClass(string $bridge_class): void
    {
        $this->bridge_class = $bridge_class;
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
