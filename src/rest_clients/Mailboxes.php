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
 * @package AriStasisApp\ariclients
 */
class Mailboxes extends AriRestClient
{
    /**
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface TODO: List[Mailbox]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function list(): array
    {
        return $this->getRequest('/mailboxes');
    }

    /**
     * @param string $mailboxName
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    function get(string $mailboxName): Mailbox
    {
        $response = $this->getRequest("/mailboxes/{$mailboxName}");
        return $this->jsonMapper->map(json_decode($response->getBody()), new Mailbox());

    }

    /**
     * @param string $mailboxName
     * @param int $oldMessages
     * @param int $newMessages
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function update(string $mailboxName, int $oldMessages, int $newMessages): void
    {
        $this->putRequest("/mailboxes/{$mailboxName}",
            ['oldMessages' => $oldMessages, 'newMessages' => $newMessages]);
    }

    /**
     * @param string $mailboxName
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function delete(string $mailboxName): void
    {
        $this->deleteRequest("/mailboxes/{$mailboxName}");
    }
}