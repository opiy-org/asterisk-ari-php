<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\RestClient;


use GuzzleHttp\Exception\GuzzleException;
use NgVoice\AriClient\Model\Playback;

/**
 * Class Playbacks
 * @package NgVoice\AriClient\RestClient
 */
class Playbacks extends AriRestClient
{
    /**
     * Get a playback's details.
     *
     * @param string $playbackId Playback's id.
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * @throws GuzzleException
     */
    public function get(string $playbackId): Playback
    {
        return $this->getRequest("/playbacks/{$playbackId}", [], parent::MODEL, Playback::class);
    }

    /**
     * Stop a playback.
     *
     * @param string $playbackId Playback's id
     * @throws GuzzleException
     */
    public function stop(string $playbackId): void
    {
        $this->deleteRequest("/playbacks/{$playbackId}");
    }

    /**
     * Control a playback.
     *
     * @param string $playbackId Playback's id.
     * @param string $operation Operation to perform on the playback.
     * Allowed: restart, pause, unpause, reverse, forward
     * @throws GuzzleException
     */
    public function control(string $playbackId, string $operation): void
    {
        $this->postRequest("/playbacks/{$playbackId}/control", ['operation' => $operation]);
    }
}