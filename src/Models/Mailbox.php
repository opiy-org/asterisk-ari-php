<?php

/** @copyright 2019 ng-voice GmbH */

namespace NgVoice\AriClient\Models;


/**
 * Represents the state of a mailbox.
 *
 * @package NgVoice\AriClient\Models
 */
final class Mailbox implements Model
{
    /**
     * @var int Count of old Message in the mailbox.
     */
    private $old_messages;

    /**
     * @var string Name of the mailbox.
     */
    private $name;

    /**
     * @var int Count of new Message in the mailbox.
     */
    private $new_messages;

    /**
     * @return int
     */
    public function getOldMessages(): int
    {
        return $this->old_messages;
    }

    /**
     * @param int $oldMessages
     */
    public function setOldMessages(int $oldMessages): void
    {
        $this->old_messages = $oldMessages;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getNewMessages(): int
    {
        return $this->new_messages;
    }

    /**
     * @param int $newMessages
     */
    public function setNewMessages(int $newMessages): void
    {
        $this->new_messages = $newMessages;
    }
}
