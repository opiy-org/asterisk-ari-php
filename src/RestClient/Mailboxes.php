<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\RestClient;


use AriStasisApp\Model\Mailbox;

/**
 * Class Mailboxes
 *
 * @package AriStasisApp\RestClient
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
     * @param int $oldMessages Count of old Message in the mailbox.
     * @param int $newMessages Count of new Message in the mailbox.
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