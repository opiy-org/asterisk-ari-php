<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\rest_clients;


use AriStasisApp\models\Application;
use function AriStasisApp\glueArrayOfStrings;

/**
 * Class Applications
 *
 * @package AriStasisApp\ariclients
 */
class Applications extends AriRestClient
{
    private const APPLICATION = 'Application';

    /**
     * List all applications on the asterisk.
     *
     * @return Application[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function list(): array
    {
        return $this->getRequest('/applications', [], 'array', self::APPLICATION);
    }

    /**
     * Get details of the application.
     *
     * @param string $applicationName Application's name.
     * @return Application|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function get(string $applicationName): Application
    {
        return $this->getRequest("/applications/{$applicationName}", [], self::MODEL, self::APPLICATION);
    }

    /**
     * Subscribe an application to a events source.
     * Returns the state of the application after the subscriptions have changed.
     *
     * @param string $applicationName Application's name.
     * @param array $eventSource URI for events source
     * (channel:{channelId}, bridge:{bridgeId}, endpoint:{tech}[/{resource}], deviceState:{deviceName}
     * @return Application|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function subscribe(string $applicationName, array $eventSource): Application
    {
        return $this->postRequest(
            "/applications/{$applicationName}/subscription",
            ['eventSource' => glueArrayOfStrings($eventSource)],
            [],
            self::MODEL,
            self::APPLICATION
        );
    }

    /**
     * Unsubscribe an application from an events source.
     * Returns the state of the application after the subscriptions have changed.
     *
     * @param string $applicationName
     * @param array $eventSource URI for events source
     * (channel:{channelId}, bridge:{bridgeId}, endpoint:{tech}[/{resource}], deviceState:{deviceName}
     * @return Application|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function unsubscribe(string $applicationName, array $eventSource): Application
    {
        return $this->deleteRequest(
            "/applications/{$applicationName}/subscription",
            ['eventSource' => glueArrayOfStrings($eventSource)],
            self::MODEL,
            self::APPLICATION
        );
    }
}