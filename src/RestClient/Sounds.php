<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\RestClient;


use GuzzleHttp\Exception\GuzzleException;
use NgVoice\AriClient\Model\Sound;

/**
 * Class Sounds
 * @package NgVoice\AriClient\RestClient
 */
final class Sounds extends AriRestClient
{
    /**
     * List all sounds.
     *
     * @param array $options
     * lang: string - Lookup sound for a specific language.
     * format: string - Lookup sound in a specific format.
     * @return Sound[]
     * @throws GuzzleException
     */
    public function list(array $options = []): array
    {
        return $this->getRequest('/sounds', $options, parent::ARRAY, Sound::class);
    }

    /**
     * Get a sound's details.
     *
     * @param string $soundId Sound's id.
     * @return Sound|object
     * @throws GuzzleException
     */
    public function get(string $soundId): Sound
    {
        return $this->getRequest("/sounds/{$soundId}", [], parent::MODEL, Sound::class);
    }
}