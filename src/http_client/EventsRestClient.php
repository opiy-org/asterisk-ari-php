<?php
/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 *
 */

namespace AriStasisApp\http_client;


use function AriStasisApp\glueArrayOfStrings;

/**
 * Class EventsRestClient
 *
 * GET /events is not part of this API because it has to be a WebSocket connection (ws:// or wss://)
 * and is handled separately in the WebSocketClient.
 *
 * @package AriStasisApp\ariclients
 */
class EventsRestClient extends AriRestClient
{
    /**
     * Generate a user event.
     *
     * @param string $eventName Event name.
     * @param string $application The name of the application that will receive this event
     * @param array $source URI for event source (channel:{channelId}, bridge:{bridgeId},
     * endpoint:{tech}/{resource}, deviceState:{deviceName})
     * TODO: Needs testing. Not clarified how nested container with variables exactly is defined.
     * @param array $variables containers - The "variables" key in the body object holds custom key/value pairs to add
     * to the user event. Ex. { "variables": { "key": "value" } }
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function userEvent(string $eventName, string $application, array $source = [], array $variables = [])
    {
        $source = glueArrayOfStrings($source);
        return $this->postRequest("/events/user/{$eventName}",
            ['application' => $application, 'source' => $source], ['variables' => $variables]);
    }
}