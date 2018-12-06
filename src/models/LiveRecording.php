<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models;


/**
 * A recording that is in progress
 *
 * @package AriStasisApp\models
 */
class LiveRecording
{
    /**
     * @var string Base name for the recording.
     */
    private $name;

    /**
     * @var string Recording format (wav, gsm, etc.).
     */
    private $format;

    /**
     * @var string URI for the channel or bridge being recorded.
     */
    private $targetUri;

    /**
     * @var string ("queued", "recording", "paused", "done", "failed", "canceled")
     */
    private $state;

    /**
     * @var int Duration in seconds of the recording.
     */
    private $duration;

    /**
     * @var int Duration of talking, in seconds, detected in the recording.
     * This is only available if the recording was initiated with a non-zero maxSilenceSeconds.
     */
    private $talkingDuration;

    /**
     * @var int Duration of silence, in seconds, detected in the recording.
     * This is only available if the recording was initiated with a non-zero maxSilenceSeconds.
     */
    private $silenceDuration;

    /**
     * @var string Cause for recording failure if failed
     */
    private $cause;

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
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @param string $format
     */
    public function setFormat(string $format): void
    {
        $this->format = $format;
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
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     */
    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }

    /**
     * @return int
     */
    public function getTalkingDuration(): int
    {
        return $this->talkingDuration;
    }

    /**
     * @param int $talkingDuration
     */
    public function setTalkingDuration(int $talkingDuration): void
    {
        $this->talkingDuration = $talkingDuration;
    }

    /**
     * @return int
     */
    public function getSilenceDuration(): int
    {
        return $this->silenceDuration;
    }

    /**
     * @param int $silenceDuration
     */
    public function setSilenceDuration(int $silenceDuration): void
    {
        $this->silenceDuration = $silenceDuration;
    }

    /**
     * @return string
     */
    public function getCause(): string
    {
        return $this->cause;
    }

    /**
     * @param string $cause
     */
    public function setCause(string $cause): void
    {
        $this->cause = $cause;
    }
}