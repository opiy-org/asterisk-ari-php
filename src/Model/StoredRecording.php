<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Model;

/**
 * A past recording that may be played back.
 *
 * @package NgVoice\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class StoredRecording implements ModelInterface
{
    private string $name;

    private string $format;

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
     * Recording format (wav, gsm, etc.).
     *
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }
}
