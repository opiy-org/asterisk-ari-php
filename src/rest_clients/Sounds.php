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
 * @package AriStasisApp\rest_clients
 */
class Sounds extends AriRestClient
{
    /**
     * List all sounds.
     *
     * @param array $options
     * lang: string - Lookup sound for a specific language.
     * format: string - Lookup sound in a specific format.
     * @return Sound[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function list(array $options = []): array
    {
        return $this->getRequest('/sounds', $options, 'array', 'Sound');
    }

    /**
     * Get a sound's details.
     *
     * @param string $soundId Sound's id.
     * @return Sound|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function get(string $soundId): Sound
    {
        return $this->getRequest("/sounds/{$soundId}", [], 'model', 'Sound');
    }
}