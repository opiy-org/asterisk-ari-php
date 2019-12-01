<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\RestClient\ResourceClient;

use NgVoice\AriClient\Collection\HttpMethods;
use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use NgVoice\AriClient\Models\Sound;
use NgVoice\AriClient\RestClient\AbstractRestClient;

/**
 * An implementation of the Sounds REST client for the
 * Asterisk REST Interface
 *
 * @see https://wiki.asterisk.org/wiki/display/AST/Asterisk+16+Sounds+REST+API
 *
 * @package NgVoice\AriClient\RestClient\ResourceClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Sounds extends AbstractRestClient
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
    public function list(array $options = [])
    {
        $response = $this->sendRequest(
            HttpMethods::GET,
            '/sounds',
            $options
        );

        /** @var Sound[] $sounds */
        $sounds = [];
        $this->responseToArrayOfAriModelInstances(
            $response,
            new Sound(),
            $sounds
        );

        return $sounds;
    }

    /**
     * Get a sound's details.
     *
     * @param string $soundId Sound's id.
     *
     * @return Sound
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function get(string $soundId): Sound
    {
        $response = $this->sendRequest(
            HttpMethods::GET,
            "/sounds/{$soundId}"
        );

        $sound = new Sound();
        $this->responseToAriModelInstance($response, $sound);

        return $sound;
    }
}
