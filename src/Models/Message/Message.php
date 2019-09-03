<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Models\Message;


/**
 * Base type for errors and events.
 *
 * @package NgVoice\AriClient\Models\Message
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class Message
{
    /**
     * @var string Indicates the type of this message.
     */
    private $type;

    /**
     * @var string The unique ID for the Asterisk instance that raised this event.
     */
    private $asterisk_id;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getAsteriskId(): string
    {
        return $this->asterisk_id;
    }

    /**
     * @param string $asteriskId
     */
    public function setAsteriskId(string $asteriskId): void
    {
        $this->asterisk_id = $asteriskId;
    }
}
