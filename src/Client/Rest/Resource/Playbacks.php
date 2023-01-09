<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Client\Rest\Resource;

use JsonException;
use OpiyOrg\AriClient\Client\Rest\AbstractRestClient;
use OpiyOrg\AriClient\Enum\HttpMethods;
use OpiyOrg\AriClient\Exception\AsteriskRestInterfaceException;
use OpiyOrg\AriClient\Model\Playback;

/**
 * An implementation of the Playbacks REST client for the
 * Asterisk REST Interface
 *
 * @see https://wiki.asterisk.org/wiki/display/AST/Asterisk+16+Playbacks+REST+API
 *
 * @package OpiyOrg\AriClient\Client\Rest\Resource
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class Playbacks extends AbstractRestClient
{
    /**
     * Get a playback's details.
     *
     * @param string $playbackId Playback's id.
     *
     * @return Playback
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     * @throws JsonException
     */
    public function get(string $playbackId): Playback
    {
        $response = $this->sendRequest(
            HttpMethods::GET,
            "/playbacks/{$playbackId}"
        );

        $playback = new Playback();
        $this->responseToAriModelInstance($response, $playback);

        return $playback;
    }

    /**
     * Stop a playback.
     *
     * @param string $playbackId Playback's id
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function stop(string $playbackId): void
    {
        $this->sendRequest(HttpMethods::DELETE, "/playbacks/{$playbackId}");
    }

    /**
     * Control a playback.
     *
     * @param string $playbackId Playback's id.
     * @param string $operation Operation to perform on the playback.
     * Allowed: restart, pause, unpause, reverse, forward
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function control(string $playbackId, string $operation): void
    {
        $this->sendRequest(
            HttpMethods::POST,
            "/playbacks/{$playbackId}/control",
            ['operation' => $operation]
        );
    }
}
