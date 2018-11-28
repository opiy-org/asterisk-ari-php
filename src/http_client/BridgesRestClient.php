<?php
/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\http_client;


/**
 * Class BridgesRestClient
 *
 * @package AriStasisApp\ariclients
 */
class BridgesRestClient extends AriRestClient
{
    /**
     * List all active bridges in Asterisk.
     *
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function list()
    {
        return $this->getRequest('/bridges');
    }

    /**
     * Create a new bridge.
     * This bridge persists until it has been shut down, or Asterisk has been shut down.
     *
     * @param string $type
     * @param string $bridgeId
     * @param string $name
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * TODO: Check if correct with documentation.
     */
    function create(string $type, string $bridgeId, string $name)
    {
        return $this->postRequest('/bridges', [$type, $bridgeId, $name]);
    }

    /**
     * Create a new bridge or updates an existing one.
     * This bridge persists until it has been shut down, or Asterisk has been shut down.
     *
     * @param string $bridgeId Unique ID to give to the bridge being created.
     * @param string $type
     * @param string $name
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * TODO: Check if correct with documentation.
     */
    function createWithId(string $bridgeId, string $type, string $name)
    {
        return $this->postRequest("/bridges/{$bridgeId}", [$type, $name]);
    }

    /**
     * @param string $bridgeId
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function get(string $bridgeId)
    {
        return $this->getRequest("/bridges/{$bridgeId}");
    }

    /**
     * @param string $bridgeId
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function destroy(string $bridgeId)
    {
        return $this->deleteRequest("/bridges/{$bridgeId}");
    }

    /**
     * @param string $bridgeId
     * @param array $channels Ids of channels to add to bridge.
     * @param string $role
     * @param bool $absorbDTMF
     * @param bool $mute
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function addChannel(string $bridgeId, array $channels, string $role, bool $absorbDTMF, bool $mute)
    {
        // TODO: split $channels array and make it a comma seperated string
        return $this->postRequest("/bridges/{$bridgeId}/addChannel",
            ['channels' => $channels, 'role' => $role, 'absorbDTMF' => $absorbDTMF, 'mute' => $mute]);
    }

    /**
     * @param string $bridgeId
     * @param array $channels
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function removeChannel(string $bridgeId, array $channels)
    {
        // TODO: split $channels array and make it a comma seperated string
        return $this->postRequest("/bridges/{$bridgeId}/removeChannel",
            ['channels' => $channels]);
    }

    /**
     * @param string $bridgeId
     * @param string $channelId
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function setVideoSource(string $bridgeId, string $channelId)
    {
        return $this->postRequest("/bridges/{$bridgeId}/videoSource/{$channelId}");
    }

    /**
     * @param string $bridgeId
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function clearVideoSource(string $bridgeId)
    {
        return $this->deleteRequest("/bridges/{$bridgeId}/videoSource");
    }

    /**
     * @param string $bridgeId
     * @param string $mohClass
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function startMoh(string $bridgeId, string $mohClass)
    {
        return $this->postRequest("/bridges/{$bridgeId}/moh",
            ['mohClass' => $mohClass]);
    }

    /**
     * @param string $bridgeId
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function stopMoh(string $bridgeId)
    {
        return $this->deleteRequest("/bridges/{$bridgeId}/moh");
    }

    /**
     * @param string $bridgeId
     * @param array $media Media URIs to play. Allows comma separated values.
     * @param array $options
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * TODO: Split media into comma seperated string.
     */
    function play(string $bridgeId, array $media, array $options = [])
    {
        return $this->postRequest("/bridges/{$bridgeId}/play",
            array_merge(['media' => $media], $options));
    }

    /**
     * @param string $bridgeId
     * @param string $playbackId
     * @param array $media
     * @param array $options
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * TODO: Split media into comma seperated string.
     */
    function playWithId(string $bridgeId, string $playbackId, array $media, array $options = [])
    {
        return $this->postRequest("/bridges/{$bridgeId}/play/{$playbackId}",
            array_merge(['media' => $media], $options));
    }

    /**
     * @param string $bridgeId
     * @param string $name
     * @param string $format
     * @param array $options
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function record(string $bridgeId, string $name, string $format, array $options = [])
    {
        return $this->postRequest("/bridges/{$bridgeId}/record",
            array_merge(['name' => $name, 'format' => $format], $options));
    }


}