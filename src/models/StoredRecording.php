<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models;


/**
 * A past recording that may be played back.
 *
 * @package AriStasisApp\models
 */
class StoredRecording
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