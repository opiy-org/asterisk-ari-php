<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models;


/**
 * Effective user/group id
 *
 * @package AriStasisApp\models
 */
class Variable
{
    /**
     * @var string The value of the variable requested
     * @required
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