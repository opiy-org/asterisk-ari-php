<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model;

/**
 * A past recording that may be played back.
 *
 * @package OpiyOrg\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class StoredRecording implements ModelInterface
{
    public string $name;

    public string $format;

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
