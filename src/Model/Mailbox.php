<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model;

/**
 * Represents the state of a mailbox.
 *
 * @package OpiyOrg\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class Mailbox implements ModelInterface
{
    public int $oldMessages;

    public string $name;

    public int $newMessages;

    /**
     * Count of old Event in the mailbox.
     *
     * @return int
     */
    public function getOldMessages(): int
    {
        return $this->oldMessages;
    }

    /**
     * Name of the mailbox.
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Count of new Event in the mailbox.
     *
     * @return int
     */
    public function getNewMessages(): int
    {
        return $this->newMessages;
    }
}
