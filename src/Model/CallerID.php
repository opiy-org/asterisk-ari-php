<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Model;

/**
 * Caller identification
 *
 * @package NgVoice\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class CallerID implements ModelInterface
{
    private string $name;

    private string $number;

    /**
     * Get the name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the number.
     *
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }
}
