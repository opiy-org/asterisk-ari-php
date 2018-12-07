<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\rest_clients;


use function AriStasisApp\{mapJsonArrayToAriObjects, mapJsonToAriObject, glueArrayOfStrings};
use AriStasisApp\models\Application;

/**
 * Class Applications
 *
 * @package AriStasisApp\ariclients
 */
class Applications extends AriRestClient
{
    /**
     * List all applications on the asterisk.
     *
     * @return Application[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function list(): array
    {
        return mapJsonArrayToAriObjects(
            $this->getRequest('/applications'),
            'AriStasisApp\models\Application',
            $this->jsonMapper,
            $this->logger);
    }

    /**
     * Get details of the application.
     *
     * @param string $applicationName
     * @return Application|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function get(string $applicationName): Application
    {
        return mapJsonToAriObject(
            $this->getRequest("/applications/{$applicationName}"),
            'AriStasisApp\models\Application',
            $this->jsonMapper,
            $this->logger
        );
    }

    /**
     * Subscribe an application to a events source.
     * Returns the state of the application after the subscriptions have changed.
     *
     * @param string $applicationName
     * @param array $eventSource URI for events source
     * (channel:{channelId}, bridge:{bridgeId}, endpoint:{tech}[/{resource}], deviceState:{deviceName}
     * @return Application|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function subscribe(string $applicationName, array $eventSource): Application
    {
        $response = $this->postRequest(
            "/applications/{$applicationName}/subscription",
            ['eventSource' => glueArrayOfStrings($eventSource)]
        );
        return mapJsonToAriObject(
            $response,
            'AriStasisApp\models\Application',
            $this->jsonMapper,
            $this->logger
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
        $response = $this->deleteRequest(
            "/applications/{$applicationName}/subscription",
            ['eventSource' => glueArrayOfStrings($eventSource)]
        );
        return mapJsonToAriObject(
            $response,
            'AriStasisApp\models\Application',
            $this->jsonMapper,
            $this->logger
        );
    }
}