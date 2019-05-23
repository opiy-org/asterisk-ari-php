<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\RestClient;

use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use NgVoice\AriClient\Models\{Model, Sound};

/**
 * An implementation of the Sounds REST client for the
 * Asterisk REST Interface
 *
 * @see https://wiki.asterisk.org/wiki/display/AST/Asterisk+16+Sounds+REST+API
 *
 * @package NgVoice\AriClient\RestClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Sounds extends AsteriskRestInterfaceClient
{
    /**
     * List all sounds.
     *
     * @param array $options A collection of options when requesting a list of sounds.
     * lang: string - Lookup sound for a specific language.
     * format: string - Lookup sound in a specific format.
     *
     * @return Sound[]
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function list(array $options = []): array
    {
        return $this->getArrayOfModelInstancesRequest(Sound::class, '/sounds', $options);
    }

    /**
     * Get a sound's details.
     *
     * @param string $soundId Sound's id.
     *
     * @return Sound|Model
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function get(string $soundId): Sound
    {
        return $this->getModelRequest(Sound::class, "/sounds/{$soundId}");
    }
}
