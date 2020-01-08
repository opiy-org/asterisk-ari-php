<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Model;

/**
 * The value of a channel variable.
 *
 * @package NgVoice\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Variable implements ModelInterface
{
    private string $value;

    /**
     * The value of the variable requested.
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
