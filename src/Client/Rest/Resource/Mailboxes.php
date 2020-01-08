<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Client\Rest\Resource;

use NgVoice\AriClient\Client\Rest\AbstractRestClient;
use NgVoice\AriClient\Collection\HttpMethods;
use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use NgVoice\AriClient\Model\Mailbox;

/**
 * An implementation of the Mailboxes REST client for the
 * Asterisk REST Interface
 *
 * @see https://wiki.asterisk.org/wiki/display/AST/Asterisk+16+Mailboxes+REST+API
 *
 * @package NgVoice\AriClient\RestClient\Resource
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Mailboxes extends AbstractRestClient
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
        $response = $this->sendRequest(HttpMethods::GET, '/mailboxes');

        /** @var Mailbox[] $mailboxes */
        $mailboxes = [];
        $this->responseToArrayOfAriModelInstances(
            $response,
            new Mailbox(),
            $mailboxes
        );

        return $mailboxes;
    }

    /**
     * Retrieve the current state of a mailbox.
     *
     * @param string $mailboxName Name of the mailbox.
     *
     * @return Mailbox
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function get(string $mailboxName): Mailbox
    {
        $response = $this->sendRequest(
            HttpMethods::GET,
            "/mailboxes/{$mailboxName}"
        );

        $mailbox = new Mailbox();
        $this->responseToAriModelInstance($response, $mailbox);

        return $mailbox;
    }

    /**
     * Change the state of a mailbox. (Note - implicitly creates the mailbox).
     *
     * @param string $mailboxName Name of the mailbox.
     * @param int $oldMessages Count of old Event in the mailbox.
     * @param int $newMessages Count of new Event in the mailbox.
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function update(string $mailboxName, int $oldMessages, int $newMessages): void
    {
        $this->sendRequest(
            HttpMethods::PUT,
            "/mailboxes/{$mailboxName}",
            [],
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
        $this->sendRequest(HttpMethods::DELETE, "/mailboxes/{$mailboxName}");
    }
}
