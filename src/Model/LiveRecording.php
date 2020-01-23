<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Model;

use NgVoice\AriClient\Enum\RecordingStates;

/**
 * A recording that is in progress.
 *
 * @package NgVoice\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class LiveRecording implements ModelInterface
{
    private ?int $talkingDuration = null;

    private string $name;

    private string $targetUri;

    private string $format;

    private ?string $cause = null;

    private string $state;

    private ?int $duration = null;

    private ?int $silenceDuration = null;

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
     * @see RecordingStates
     *
     * @return string
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
