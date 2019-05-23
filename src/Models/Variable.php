<?php

/** @copyright 2019 ng-voice GmbH */

namespace NgVoice\AriClient\Models;


/**
 * Effective user/group id
 *
 * @package NgVoice\AriClient\Models
 */
final class Variable implements Model
{
    /**
     * @var string The value of the variable requested
     */
    private $value;

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}
