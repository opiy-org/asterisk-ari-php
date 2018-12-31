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
    private $oldMessages;

    /**
     * @var string Name of the mailbox.
     */
    private $name;

    /**
     * @var int Count of new messages in the mailbox.
     */
    private $newMessages;

    /**
     * @return int
     */
    public function getOldMessages(): int
    {
        return $this->oldMessages;
    }

    /**
     * @param int $oldMessages
     */
    public function setOldMessages(int $oldMessages): void
    {
        $this->oldMessages = $oldMessages;
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
        return $this->newMessages;
    }

    /**
     * @param int $newMessages
     */
    public function setNewMessages(int $newMessages): void
    {
        $this->newMessages = $newMessages;
    }
}