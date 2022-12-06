<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model;

use OpiyOrg\AriClient\Enum\RecordingStates;

/**
 * A recording that is in progress.
 *
 * @package OpiyOrg\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class LiveRecording implements ModelInterface
{
    public ?int $talkingDuration = null;

    public string $name;

    public string $targetUri;

    public string $format;

    public ?string $cause = null;

    public string $state;

    public ?int $duration = null;

    public ?int $silenceDuration = null;

    /**
     * Duration of talking, in seconds, detected in the recording.
     *
     * This is only available if the recording was initiated with
     * a non-zero maxSilenceSeconds.
     *
     * @return int|null
     */
    public function getTalkingDuration(): ?int
    {
        return $this->talkingDuration;
    }

    /**
     * Base name for the recording.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * URI for the channel or bridge being recorded.
     *
     * @return string
     */
    public function getTargetUri(): string
    {
        return $this->targetUri;
    }

    /**
     * Recording format (wav, gsm, etc.).
     *
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * Cause for recording failure if failed.
     *
     * @return string|null
     */
    public function getCause(): ?string
    {
        return $this->cause;
    }

    /**
     * The recordings state.
     *
     * @return string
     * @see RecordingStates
     *
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * Duration in seconds of the recording.
     *
     * @return int|null
     */
    public function getDuration(): ?int
    {
        return $this->duration;
    }

    /**
     * Duration of silence, in seconds, detected in the recording.
     *
     * This is only available if the recording was initiated with a
     * non-zero maxSilenceSeconds.
     *
     * @return int|null
     */
    public function getSilenceDuration(): ?int
    {
        return $this->silenceDuration;
    }
}
