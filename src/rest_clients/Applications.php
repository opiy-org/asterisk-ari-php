<?php
/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 *
 */

namespace AriStasisApp\rest_clients;


/**
 * Class Applications
 *
 * @package AriStasisApp\ariclients
 */
class Applications extends AriRestClient
{
    /**
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function list()
    {
        return $this->getRequest('/applications');
    }

    /**
     * @param string $applicationName
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function get(string $applicationName)
    {
        return $this->getRequest("/applications/{$applicationName}");
    }

    /**
     * @param string $applicationName
     * @param array $eventSource URI for event source
     * (channel:{channelId}, bridge:{bridgeId}, endpoint:{tech}[/{resource}], deviceState:{deviceName}
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function subscribe(string $applicationName, array $eventSource)
    {
        //TODO: Split array and put it into the right format (not only comma seperated) -> documentation
        return $this->postRequest("/applications/{$applicationName}/subscription",
            ['eventSource' => $eventSource]);
    }

    /**
     * @param string $applicationName
     * @param array $eventSource URI for event source
     * (channel:{channelId}, bridge:{bridgeId}, endpoint:{tech}[/{resource}], deviceState:{deviceName}
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function unsubscribe(string $applicationName, array $eventSource)
    {
        //TODO: Split array and put it into the right format (not only comma seperated) -> documentation
        return $this->deleteRequest("/applications/{$applicationName}/subscription",
            ['eventSource' => $eventSource]);
    }

}