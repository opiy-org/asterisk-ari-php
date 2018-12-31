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
 * @package AriStasisApp\rest_clients
 */
class Playbacks extends AriRestClient
{
    /**
     * Get a playback's details.
     *
     * @param string $playbackId Playback's id.
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function get(string $playbackId): Playback
    {
        return $this->getRequest("/playbacks/{$playbackId}", [], 'model', 'Playback');
    }

    /**
     * Stop a playback.
     *
     * @param string $playbackId Playback's id
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function stop(string $playbackId): void
    {
        $this->deleteRequest("/playbacks/{$playbackId}");
    }

    /**
     * Control a playback.
     *
     * @param string $playbackId Playback's id.
     * @param string $operation Operation to perform on the playback.
     * Allowed: restart, pause, unpause, reverse, forward
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function control(string $playbackId, string $operation): void
    {
        $this->postRequest("/playbacks/{$playbackId}/control", ['operation' => $operation]);
    }
}