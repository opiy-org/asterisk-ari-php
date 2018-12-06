<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\rest_clients;


use function AriStasisApp\glueArrayOfStrings;

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
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function list()
    {
        return $this->getRequest('/applications');
    }


    /**
     * Get details of the application.
     *
     * @param string $applicationName
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function get(string $applicationName)
    {
        return $this->getRequest("/applications/{$applicationName}");
    }


    /**
     * Subscribe an application to a events source.
     * Returns the state of the application after the subscriptions have changed.
     *
     * @param string $applicationName
     * @param array $eventSource URI for events source
     * (channel:{channelId}, bridge:{bridgeId}, endpoint:{tech}[/{resource}], deviceState:{deviceName}
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function subscribe(string $applicationName, array $eventSource)
    {
        return $this->postRequest("/applications/{$applicationName}/subscription",
            ['eventSource' => glueArrayOfStrings($eventSource)]);
    }


    /**
     * Unsubscribe an application from an events source.
     * Returns the state of the application after the subscriptions have changed.
     *
     * @param string $applicationName
     * @param array $eventSource URI for events source
     * (channel:{channelId}, bridge:{bridgeId}, endpoint:{tech}[/{resource}], deviceState:{deviceName}
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function unsubscribe(string $applicationName, array $eventSource)
    {
        return $this->deleteRequest("/applications/{$applicationName}/subscription",
            ['eventSource' => glueArrayOfStrings($eventSource)]);
    }
}