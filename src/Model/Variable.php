<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model;

/**
 * The value of a channel variable.
 *
 * @package OpiyOrg\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class Variable implements ModelInterface
{
    private ?string $key;

    public string $value;

    /**
     * The value of the variable.
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
