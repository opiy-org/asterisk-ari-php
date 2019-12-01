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
 * Object representing the playback of media to a channel
 *
 * @package NgVoice\AriClient\Models
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Playback implements ModelInterface
{
    /**
     * @var string If a list of URIs is being played, the next media URI to be played back.
     */
    private $next_media_uri;

    /**
     * @var string URI for the channel or bridge to play the media on.
     */
    private $target_uri;

    /**
     * @var string For media types that support multiple languages, the language requested for playback.
     */
    private $language;

    /**
     * @var string Current state of the playback operation ("queued", "playing", "continuing", "done").
     */
    private $state;

    /**
     * @var string The URI for the media currently being played back.
     */
    private $media_uri;

    /**
     * @var string ID for this playback operation.
     */
    private $id;

    /**
     * @return string
     */
    public function getNextMediaUri(): string
    {
        return $this->next_media_uri;
    }

    /**
     * @param string $next_media_uri
     */
    public function setNextMediaUri(string $next_media_uri): void
    {
        $this->next_media_uri = $next_media_uri;
    }

    /**
     * @return string
     */
    public function getTargetUri(): string
    {
        return $this->target_uri;
    }

    /**
     * @param string $target_uri
     */
    public function setTargetUri(string $target_uri): void
    {
        $this->target_uri = $target_uri;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState(string $state): void
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getMediaUri(): string
    {
        return $this->media_uri;
    }

    /**
     * @param string $media_uri
     */
    public function setMediaUri(string $media_uri): void
    {
        $this->media_uri = $media_uri;
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
