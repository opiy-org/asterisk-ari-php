<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Model\Message;

/**
 * Base type for errors and events.
 *
 * @package NgVoice\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class Message
{
    private string $type;

    private ?string $asteriskId = null;

    /**
     * Indicates the type of this message.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * The unique ID for the Asterisk instance that raised this event.
     *
     * @return string|null
     */
    public function getAsteriskId(): ?string
    {
        return $this->asteriskId;
    }
}
