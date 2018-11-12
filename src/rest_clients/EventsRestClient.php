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
 * Class EventsRestClient
 *
 * GET /events is not part of this API because it has to be a WebSocket connection (ws:// or wss://)
 * and is handled separately in the AriWebSocketClient.
 *
 * @package AriStasisApp\ariclients
 */
class EventsRestClient extends AriRestClient
{
    /**
     * @param string $eventName
     * @param int $oldMessages
     * @param int $newMessages
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function userEvent(string $eventName, int $oldMessages, int $newMessages)
    {
        return $this->postRequest("/events/{$eventName}",
            ['oldMessages' => $oldMessages, 'newMessages' => $newMessages]);
    }
}