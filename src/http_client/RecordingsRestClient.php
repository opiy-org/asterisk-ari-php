<?php

/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\http_client;


/**
 * Class RecordingsRestClient
 *
 * @package AriStasisApp\rest_clients
 */
class RecordingsRestClient extends AriRestClient
{
    /**
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function listStored()
    {
        return $this->getRequest('/recordings/stored');
    }

    /**
     * @param string $recordingName
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function getStored(string $recordingName)
    {
        return $this->getRequest("/recordings/stored/{$recordingName}");
    }

    /**
     * @param string $recordingName
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function deleteStored(string $recordingName)
    {
        return $this->deleteRequest("/recordings/stored/{$recordingName}");
    }

    /**
     * @param string $recordingName
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     *
     * TODO: We await a base 64 encoded bitstream here
     */
    function getStoredFile(string $recordingName)
    {
        return $this->getRequest("/recordings/stored/{$recordingName}/file");
    }

    /**
     * @param string $recordingName
     * @param string $destinationRecordingName
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function copyStored(string $recordingName, string $destinationRecordingName)
    {
        return $this->postRequest("/recordings/stored/{$recordingName}/copy",
            ['destinationRecordingName' => $destinationRecordingName]);
    }

    /**
     * @param string $recordingName
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function getLive(string $recordingName)
    {
        return $this->getRequest("/recordings/live/{$recordingName}");
    }

    /**
     * @param string $recordingName
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function cancel(string $recordingName)
    {
        return $this->deleteRequest("/recordings/live/{$recordingName}");
    }

    /**
     * @param string $recordingName
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function stop(string $recordingName)
    {
        return $this->postRequest("/recordings/live/{$recordingName}/stop");
    }

    /**
     * @param string $recordingName
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function pause(string $recordingName)
    {
        return $this->postRequest("/recordings/live/{$recordingName}/pause");
    }

    /**
     * @param string $recordingName
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function unpause(string $recordingName)
    {
        return $this->deleteRequest("/recordings/live/{$recordingName}/pause");
    }

    /**
     * @param string $recordingName
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function mute(string $recordingName)
    {
        return $this->postRequest("/recordings/live/{$recordingName}/mute");
    }

    /**
     * @param string $recordingName
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function unmute(string $recordingName)
    {
        return $this->deleteRequest("/recordings/live/{$recordingName}/mute");
    }
}