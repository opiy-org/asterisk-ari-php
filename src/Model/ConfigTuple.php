<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\Model;


/**
 * A key/value pair that makes up part of a configuration object.
 *
 * @package AriStasisApp\Model
 */
class ConfigTuple
{
    /**
     * @var string A configuration object attribute.
     * @required
     */
    private $attribute;

    /**
     * @var string The value for the attribute.
     * @required
     */
    private $value;

    /**
     * @return string
     */
    public function getAttribute(): string
    {
        return $this->attribute;
    }

    /**
     * @param string $attribute
     */
    public function setAttribute(string $attribute): void
    {
        $this->attribute = $attribute;
    }

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