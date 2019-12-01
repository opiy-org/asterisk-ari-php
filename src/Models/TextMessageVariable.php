<?php

/**
 * The JSONMapper library needs the full name path of
 * a class, so there are no imports used instead.
 *
 * @noinspection PhpFullyQualifiedNameUsageInspection
 */

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Models;

/**
 * A key/value pair variable in a text message.
 *
 * @package NgVoice\AriClient\Models
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class TextMessageVariable implements ModelInterface
{
    /**
     * @var string The value of the variable.
     */
    private $value;

    /**
     * @var string A unique key identifying the variable.
     */
    private $key;

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

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey(string $key): void
    {
        $this->key = $key;
    }
}
