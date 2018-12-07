<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\rest_clients;


use function AriStasisApp\{mapJsonToAriObject, mapJsonArrayToAriObjects};
use AriStasisApp\models\Sound;

/**
 * Class Sounds
 *
 * @package AriStasisApp\ariclients
 */
class Sounds extends AriRestClient
{
    /**
     * @return Sound[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function list(): array
    {
        return mapJsonArrayToAriObjects(
            $this->getRequest('/sounds'),
            'AriStasisApp\models\Sound',
            $this->jsonMapper,
            $this->logger
        );
    }

    /**
     * @param string $soundId
     * @return Sound|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function get(string $soundId): Sound
    {
        return mapJsonToAriObject(
            $this->getRequest("/sounds/{$soundId}"),
            'AriStasisApp\models\Sound',
            $this->jsonMapper,
            $this->logger
        );
    }
}