<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\RestClient;

use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use NgVoice\AriClient\Models\{Model, Playback};

/**
 * An implementation of the Playbacks REST client for the
 * Asterisk REST Interface
 *
 * @see https://wiki.asterisk.org/wiki/display/AST/Asterisk+16+Playbacks+REST+API
 *
 * @package NgVoice\AriClient\RestClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Playbacks extends AsteriskRestInterfaceClient
{
    /**
     * Get a playback's details.
     *
     * @param string $playbackId Playback's id.
     *
     * @return Playback|Model
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function get(string $playbackId): Playback
    {
        return $this->getModelRequest(Playback::class, "/playbacks/{$playbackId}");
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
        $this->deleteRequest("/playbacks/{$playbackId}");
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
        $this->postRequest(
            "/playbacks/{$playbackId}/control",
            ['operation' => $operation]
        );
    }
}
