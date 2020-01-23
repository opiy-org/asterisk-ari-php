<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Client\Rest\Resource;

use NgVoice\AriClient\Client\Rest\AbstractRestClient;
use NgVoice\AriClient\Enum\HttpMethods;
use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;

/**
 * An implementation of the Events REST client for the
 * Asterisk REST Interface
 *
 * @see https://wiki.asterisk.org/wiki/display/AST/Asterisk+16+Events+REST+API
 *
 * GET /events is not part of this API because it has to be a WebSocket connection (ws://
 * or wss://) and is handled separately in the WebSocket of this library.
 *
 * @package NgVoice\AriClient\Client\Rest\Resource
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Events extends AbstractRestClient
{
    /**
     * Generate a stasis application user events.
     *
     * @param string $eventName The user events name
     * @param string $application The name of the application that will receive this
     *     events
     * @param string[] $source URI for events source (channel:{channelId},
     *     bridge:{bridgeId}, endpoint:{tech}/{resource}, deviceState:{deviceName})
     * @param string[] $variables containers - The "variables" key in the body object
     *     holds custom key/value pairs to add to the user events. Ex. { "variables": {
     *     "key": "value" } }
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function userEvent(
        string $eventName,
        string $application,
        array $source = [],
        array $variables = []
    ): void {
        $body = [];
        $queryParameters = ['application' => $application];

        if ($source !== []) {
            $sourceString = '';
            foreach ($source as $sourceType => $sourceValue) {
                $sourceString = "{$sourceString},{$sourceType}:{$sourceValue}";
            }
            $queryParameters += ['source' => ltrim($sourceString, ',')];
        }

        if ($variables !== []) {
            $formattedVariables = [];
            foreach ($variables as $key => $value) {
                $formattedVariables[] = [$key => $value];
            }
            $body['variables'] = $formattedVariables;
        }

        $this->sendRequest(
            HttpMethods::POST,
            "/events/user/{$eventName}",
            $queryParameters,
            $body
        );
    }
}
