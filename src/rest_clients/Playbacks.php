<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\rest_clients;


use AriStasisApp\models\Playback;

/**
 * Class Playbacks
 *
 * @package AriStasisApp\ariclients
 */
class Playbacks extends AriRestClient
{
    /**
     * @param string $playbackId
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    function get(string $playbackId)
    {
        $response = $this->getRequest("/playbacks/{$playbackId}");
        return $this->jsonMapper->map(json_decode($response->getBody()), new Playback());
    }

    /**
     * @param string $playbackId
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function stop(string $playbackId): void
    {
        $this->deleteRequest("/playbacks/{$playbackId}");
    }

    /**
     * @param string $playbackId
     * @param string $operation Allowed: restart, pause, unpause, reverse, forward
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function control(string $playbackId, string $operation): void
    {
        $this->postRequest("/playbacks/{$playbackId}/control", ['operation' => $operation]);
    }
}