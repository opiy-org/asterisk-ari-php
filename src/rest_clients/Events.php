<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 *
 */

namespace AriStasisApp\rest_clients;


/**
 * Class Events
 *
 * GET /events is not part of this API because it has to be a WebSocket connection (ws:// or wss://)
 * and is handled separately in the WebSocketClient of this library.
 *
 * @package AriStasisApp\rest_clients
 */
class Events extends AriRestClient
{
    private const VARIABLES = 'variables';

    /**
     * Generate a stasis application user events.
     *
     * @param string $eventName events name.
     * @param string $application The name of the application that will receive this events
     * @param string[] $source URI for events source (channel:{channelId}, bridge:{bridgeId},
     * endpoint:{tech}/{resource}, deviceState:{deviceName})
     * @param string[] $variables containers - The "variables" key in the body object holds custom key/value pairs to add
     * to the user events. Ex. { "variables": { "key": "value" } }
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function userEvent(string $eventName, string $application, array $source = [], array $variables = []): void
    {
        $queryParameters = ['application' => $application];
        if ($source !== []) {
            $sourceString = '';
            foreach ($source as $sourceType => $sourceValue) {
                $sourceString = "{$sourceString},{$sourceType}:{$sourceValue}";
            }
            $queryParameters = $queryParameters + ['source' => ltrim($sourceString, ',')];
        }

        $body = [];
        if ($variables !== []) {
            $body = [self::VARIABLES => []];
            foreach ($variables as $key => $value) {
                $body[self::VARIABLES] = $body[self::VARIABLES] + [$key => $value];
            }
        }
        $this->postRequest("/events/user/{$eventName}", $queryParameters, $body);
    }
}