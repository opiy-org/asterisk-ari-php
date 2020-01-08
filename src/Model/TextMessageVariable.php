<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Model;

/**
 * A key/value pair variable in a text message.
 *
 * @package NgVoice\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class TextMessageVariable implements ModelInterface
{
    private string $key;

    private string $value;

    /**
     * A unique key identifying the variable.
     *
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

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
