<?php
/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 *
 */

namespace AriStasisApp\rest_clients;


use function AriStasisApp\glueArrayOfStrings;

/**
 * Class Events
 *
 * GET /events is not part of this API because it has to be a WebSocket connection (ws:// or wss://)
 * and is handled separately in the WebSocketClient of this library.
 *
 * @package AriStasisApp\ariclients
 */
class Events extends AriRestClient
{
    /**
     * Generate a stasis application user events.
     *
     * @param string $eventName events name.
     * @param string $application The name of the application that will receive this events
     * @param array $source URI for events source (channel:{channelId}, bridge:{bridgeId},
     * endpoint:{tech}/{resource}, deviceState:{deviceName})
     * @param array $variables containers - The "variables" key in the body object holds custom key/value pairs to add
     * to the user events. Ex. { "variables": { "key": "value" } }
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function userEvent(string $eventName, string $application, array $source = [], array $variables = []): void
    {
        $queryParameters = ['application' => $application];
        $body = [];

        if ($source !== []) {
            $queryParameters = $queryParameters + ['source' => glueArrayOfStrings($source)];
        }

        if ($variables !== []) {
            $body = ['variables' => []];
            foreach ($variables as $key => $value) {
                $body['variables'] = $body['variables'] + [$key => $value];
            }
        }
        $this->postRequest("/events/user/{$eventName}", $queryParameters, $body);
    }
}