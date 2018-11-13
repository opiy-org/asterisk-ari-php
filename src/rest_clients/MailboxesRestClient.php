<?php

/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 *
 * @OA\Info(
 *     title="Asterisk ARI Library",
 *     version="0.1",
 *     @OA\Contact(
 *         email="support@ng-voice.com"
 *     )
 * )
 *
 */

namespace AriStasisApp\rest_clients;


/**
 * Class MailboxesRestClient
 *
 * @package AriStasisApp\ariclients
 */
class MailboxesRestClient extends AriRestClient
{
    /**
     * @OA\Get(
     *     path="/applications",
     *     @OA\Response(response="200", description="An example resource")
     * )
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function list()
    {
        return $this->getRequest('/mailboxes');
    }

    /**
     * @param string $mailboxName
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function get(string $mailboxName)
    {
        return $this->getRequest("/mailboxes/{$mailboxName}");
    }

    /**
     * @param string $mailboxName
     * @param int $oldMessages
     * @param int $newMessages
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function update(string $mailboxName, int $oldMessages, int $newMessages)
    {
        return $this->putRequest("/mailboxes/{$mailboxName}",
            ['oldMessages' => $oldMessages, 'newMessages' => $newMessages]);
    }

    /**
     * @param string $mailboxName
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function delete(string $mailboxName)
    {
        return $this->deleteRequest("/mailboxes/{$mailboxName}");
    }
}