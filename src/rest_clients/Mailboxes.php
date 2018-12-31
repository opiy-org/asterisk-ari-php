<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\rest_clients;


use AriStasisApp\models\Mailbox;

/**
 * Class Mailboxes
 *
 * @package AriStasisApp\rest_clients
 */
class Mailboxes extends AriRestClient
{
    /**
     * List all mailboxes.
     *
     * @return Mailbox[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function list(): array
    {
        return $this->getRequest('/mailboxes', [], 'array', 'Mailbox');
    }

    /**
     * Retrieve the current state of a mailbox.
     *
     * @param string $mailboxName Name of the mailbox.
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function get(string $mailboxName): Mailbox
    {
        return $this->getRequest("/mailboxes/{$mailboxName}", [], 'model', 'Mailbox');

    }

    /**
     * Change the state of a mailbox. (Note - implicitly creates the mailbox).
     *
     * @param string $mailboxName Name of the mailbox.
     * @param int $oldMessages Count of old messages in the mailbox.
     * @param int $newMessages Count of new messages in the mailbox.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function update(string $mailboxName, int $oldMessages, int $newMessages): void
    {
        $this->putRequest("/mailboxes/{$mailboxName}", ['oldMessages' => $oldMessages, 'newMessages' => $newMessages]);
    }

    /**
     * Destroy a mailbox.
     *
     * @param string $mailboxName Name of the mailbox
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function delete(string $mailboxName): void
    {
        $this->deleteRequest("/mailboxes/{$mailboxName}");
    }
}