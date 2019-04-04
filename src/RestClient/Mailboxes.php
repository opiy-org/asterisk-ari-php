<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\RestClient;


use GuzzleHttp\Exception\GuzzleException;
use NgVoice\AriClient\Model\Mailbox;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Mailboxes
 * @package NgVoice\AriClient\RestClient
 */
final class Mailboxes extends AriRestClient
{
    /**
     * List all mailboxes.
     *
     * @return Mailbox[]
     * @throws GuzzleException
     */
    public function list(): array
    {
        return $this->getRequest('/mailboxes', [], parent::ARRAY, Mailbox::class);
    }

    /**
     * Retrieve the current state of a mailbox.
     *
     * @param string $mailboxName Name of the mailbox.
     * @return bool|mixed|ResponseInterface
     * @throws GuzzleException
     */
    public function get(string $mailboxName): Mailbox
    {
        return $this->getRequest("/mailboxes/{$mailboxName}", [], parent::MODEL, Mailbox::class);

    }

    /**
     * Change the state of a mailbox. (Note - implicitly creates the mailbox).
     *
     * @param string $mailboxName Name of the mailbox.
     * @param int $oldMessages Count of old Message in the mailbox.
     * @param int $newMessages Count of new Message in the mailbox.
     * @throws GuzzleException
     */
    public function update(string $mailboxName, int $oldMessages, int $newMessages): void
    {
        $this->putRequest("/mailboxes/{$mailboxName}", ['oldMessages' => $oldMessages, 'newMessages' => $newMessages]);
    }

    /**
     * Destroy a mailbox.
     *
     * @param string $mailboxName Name of the mailbox
     * @throws GuzzleException
     */
    public function delete(string $mailboxName): void
    {
        $this->deleteRequest("/mailboxes/{$mailboxName}");
    }
}