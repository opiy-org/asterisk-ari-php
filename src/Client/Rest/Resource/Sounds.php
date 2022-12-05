<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Client\Rest\Resource;

use OpiyOrg\AriClient\Client\Rest\AbstractRestClient;
use OpiyOrg\AriClient\Enum\HttpMethods;
use OpiyOrg\AriClient\Exception\AsteriskRestInterfaceException;
use OpiyOrg\AriClient\Model\Sound;

/**
 * An implementation of the Sounds REST client for the
 * Asterisk REST Interface
 *
 * @see https://wiki.asterisk.org/wiki/display/AST/Asterisk+16+Sounds+REST+API
 *
 * @package OpiyOrg\AriClient\Client\Rest\Resource
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class Sounds extends AbstractRestClient
{
    /**
     * List all sounds.
     *
     * @param array<string, string> $options A collection
     * of options when requesting a list of sounds.
     * lang: string - Lookup sound for a specific language.
     * format: string - Lookup sound in a specific format.
     *
     * @return array<Sound>
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function list(array $options = []): array
    {
        $response = $this->sendRequest(
            HttpMethods::GET,
            '/sounds',
            $options
        );

        /** @var array<int, Sound> $sounds */
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
