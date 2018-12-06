<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\rest_clients;


use AriStasisApp\models\Sound;

/**
 * Class Sounds
 *
 * @package AriStasisApp\ariclients
 */
class Sounds extends AriRestClient
{
    /**
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface TODO: List[Sound]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function list()
    {
        return $this->getRequest('/sounds');
    }

    /**
     * @param string $soundId
     * @return Sound|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    function get(string $soundId): Sound
    {
        $response = $this->getRequest("/sounds/{$soundId}");
        return $this->jsonMapper->map(json_decode($response->getBody()), new Sound());
    }
}