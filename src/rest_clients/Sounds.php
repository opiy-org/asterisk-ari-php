<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\rest_clients;


use AriStasisApp\models\Sound;
use JsonMapper_Exception;

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
     */
    function get(string $soundId): Sound
    {
        $response = $this->getRequest("/sounds/{$soundId}");
        try {
            return $this->jsonMapper->map(json_decode($response->getBody()), new Sound());
        }
        catch (JsonMapper_Exception $jsonMapper_Exception) {
            $this->logger->error($jsonMapper_Exception->getMessage());
            exit;
        }
    }
}