<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Model;

/**
 * Represents the state of a mailbox.
 *
 * @package NgVoice\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Mailbox implements ModelInterface
{
    private int $oldMessages;

    private string $name;

    private int $newMessages;

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
     * @return string
     */
    public function getName(): string
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
