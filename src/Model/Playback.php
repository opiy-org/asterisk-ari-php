<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model;

use OpiyOrg\AriClient\Enum\PlaybackStates;

/**
 * Object representing the playback of media to a channel.
 *
 * @package OpiyOrg\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class Playback implements ModelInterface
{
    public ?string $nextMediaUri = null;

    public string $targetUri;

    public ?string $language = null;

    public string $state;

    public string $mediaUri;

    public string $id;

    /**
     * If a list of URIs is being played, the next media URI to be played back.
     *
     * @return string|null
     */
    public function getNextMediaUri(): ?string
    {
        return $this->nextMediaUri;
    }

    /**
     * URI for the channel or bridge to play the media on.
     *
     * @return string
     */
    public function getTargetUri(): string
    {
        return $this->targetUri;
    }

    /**
     * For media types that support multiple languages,
     * the language requested for playback.
     *
     * @return string|null
     */
    public function getLanguage(): ?string
    {
        return $this->language;
    }

    /**
     * Current state of the playback operation.
     *
     * @return string
     * @see PlaybackStates
     *
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * The URI for the media currently being played back.
     *
     * @return string
     */
    public function getMediaUri(): string
    {
        return $this->mediaUri;
    }

    /**
     * ID for this playback operation.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}
