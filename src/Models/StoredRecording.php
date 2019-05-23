<?php

/** @copyright 2019 ng-voice GmbH */

namespace NgVoice\AriClient\Models;


/**
 * A past recording that may be played back.
 *
 * @package NgVoice\AriClient\Models
 */
final class StoredRecording implements Model
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
}
