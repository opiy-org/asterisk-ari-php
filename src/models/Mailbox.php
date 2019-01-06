<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models;


/**
 * Represents the state of a mailbox.
 *
 * @package AriStasisApp\models
 */
class Mailbox
{
    /**
     * @var int Count of old messages in the mailbox.
     */
    private $old_messages;

    /**
     * @var string Name of the mailbox.
     */
    private $name;

    /**
     * @var int Count of new messages in the mailbox.
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