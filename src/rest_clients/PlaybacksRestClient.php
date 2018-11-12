<?php
/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 *
 * @OA\Info(
 *     title="Asterisk ARI Library",
 *     version="0.1",
 *     @OA\Contact(
 *         email="support@ng-voice.com"
 *     )
 * )
 *
 */

namespace AriStasisApp\rest_clients;


/**
 * Class PlaybacksRestClient
 *
 * @package AriStasisApp\ariclients
 */
class PlaybacksRestClient extends AriRestClient
{
    /**
     * @param string $playbackId
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function get(string $playbackId)
    {
        return $this->getRequest("/playbacks/{$playbackId}");
    }

    /**
     * @param string $playbackId
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function stop(string $playbackId)
    {
        return $this->deleteRequest("/playbacks/{$playbackId}");
    }

    /**
     * @param string $playbackId
     * @param string $operation Allowed: restart, pause, unpause, reverse, forward
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function control(string $playbackId, string $operation)
    {
        return $this->postRequest("/playbacks/{$playbackId}/control",
            ['operation' => $operation]);
    }
}