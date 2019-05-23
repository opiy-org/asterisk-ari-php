<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\RestClient;

use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use NgVoice\AriClient\Models\{Mailbox, Model};

/**
 * An implementation of the Mailboxes REST client for the
 * Asterisk REST Interface
 *
 * @see https://wiki.asterisk.org/wiki/display/AST/Asterisk+16+Mailboxes+REST+API
 *
 * @package NgVoice\AriClient\RestClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Mailboxes extends AsteriskRestInterfaceClient
{
    /**
     * List all mailboxes.
     *
     * @return Mailbox[]
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function list(): array
    {
        return $this->getArrayOfModelInstancesRequest(Mailbox::class, '/mailboxes');
    }

    /**
     * Retrieve the current state of a mailbox.
     *
     * @param string $mailboxName Name of the mailbox.
     *
     * @return Mailbox|Model
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function get(string $mailboxName): Mailbox
    {
        return $this->getModelRequest(Mailbox::class, "/mailboxes/{$mailboxName}");
    }

    /**
     * Change the state of a mailbox. (Note - implicitly creates the mailbox).
     *
     * @param string $mailboxName Name of the mailbox.
     * @param int $oldMessages Count of old Message in the mailbox.
     * @param int $newMessages Count of new Message in the mailbox.
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function update(string $mailboxName, int $oldMessages, int $newMessages): void
    {
        $this->putRequest(
            "/mailboxes/{$mailboxName}",
            ['oldMessages' => $oldMessages, 'newMessages' => $newMessages]
        );
    }

    /**
     * Destroy a mailbox.
     *
     * @param string $mailboxName Name of the mailbox
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function delete(string $mailboxName): void
    {
        $this->deleteRequest("/mailboxes/{$mailboxName}");
    }
}
