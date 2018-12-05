<?php
/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models;


/**
 * Object representing the playback of media to a channel
 *
 * @package AriStasisApp\models
 */
class Playback
{
    /**
     * @var string ID for this playback operation.
     */
    private $id;

    /**
     * @var string The URI for the media currently being played back.
     */
    private $mediaUri;

    /**
     * @var string If a list of URIs is being played, the next media URI to be played back.
     */
    private $nextMediaUri;

    /**
     * @var string URI for the channel or bridge to play the media on.
     */
    private $targetUri;

    /**
     * @var string For media types that support multiple languages, the language requested for playback.
     */
    private $language;

    /**
     * @var string Current state of the playback operation ("queued", "playing", "continuing", "done").
     */
    private $state;

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
    public function getMediaUri(): string
    {
        return $this->mediaUri;
    }

    /**
     * @param string $mediaUri
     */
    public function setMediaUri(string $mediaUri): void
    {
        $this->mediaUri = $mediaUri;
    }

    /**
     * @return string
     */
    public function getNextMediaUri(): string
    {
        return $this->nextMediaUri;
    }

    /**
     * @param string $nextMediaUri
     */
    public function setNextMediaUri(string $nextMediaUri): void
    {
        $this->nextMediaUri = $nextMediaUri;
    }

    /**
     * @return string
     */
    public function getTargetUri(): string
    {
        return $this->targetUri;
    }

    /**
     * @param string $targetUri
     */
    public function setTargetUri(string $targetUri): void
    {
        $this->targetUri = $targetUri;
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
}