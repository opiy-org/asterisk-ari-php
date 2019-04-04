<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\Model;


/**
 * A recording that is in progress
 *
 * @package NgVoice\AriClient\Model
 */
class LiveRecording
{
    /**
     * @var int Duration of talking, in seconds, detected in the recording.
     * This is only available if the recording was initiated with a non-zero maxSilenceSeconds.
     */
    private $talking_duration;

    /**
     * @var string Base name for the recording.
     */
    private $name;

    /**
     * @var string URI for the channel or bridge being recorded.
     */
    private $target_uri;

    /**
     * @var string Recording format (wav, gsm, etc.).
     */
    private $format;

    /**
     * @var string Cause for recording failure if failed.
     */
    private $cause;

    /**
     * @var string ("queued", "recording", "paused", "done", "failed", "canceled").
     */
    private $state;

    /**
     * @var int Duration in seconds of the recording.
     */
    private $duration;

    /**
     * @var int Duration of silence, in seconds, detected in the recording.
     * This is only available if the recording was initiated with a non-zero maxSilenceSeconds.
     */
    private $silence_duration;

    /**
     * @return int
     */
    public function getTalkingDuration(): int
    {
        return $this->talking_duration;
    }

    /**
     * @param int $talking_duration
     */
    public function setTalkingDuration(int $talking_duration): void
    {
        $this->talking_duration = $talking_duration;
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
    public function getSilenceDuration(): int
    {
        return $this->silence_duration;
    }

    /**
     * @param int $silence_duration
     */
    public function setSilenceDuration(int $silence_duration): void
    {
        $this->silence_duration = $silence_duration;
    }

}