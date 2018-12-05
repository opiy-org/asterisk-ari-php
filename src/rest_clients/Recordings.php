<?php

/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\rest_clients;


use AriStasisApp\models\LiveRecording;
use AriStasisApp\models\StoredRecording;

/**
 * Class Recordings
 *
 * @package AriStasisApp\rest_clients
 */
class Recordings extends AriRestClient
{
    /**
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface  TODO: List[StoredRecording]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function listStored()
    {
        return $this->getRequest('/recordings/stored');
    }

    /**
     * @param string $recordingName
     * @return StoredRecording|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    function getStored(string $recordingName): StoredRecording
    {
        $response = $this->getRequest("/recordings/stored/{$recordingName}");
        return $this->jsonMapper->map(json_decode($response->getBody()), new StoredRecording());
    }

    /**
     * @param string $recordingName
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function deleteStored(string $recordingName): void
    {
        $this->deleteRequest("/recordings/stored/{$recordingName}");
    }

    /**
     * @param string $recordingName
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * TODO: Test what is returned here and how it can be played. Maybe not save it locally?!
     *   If we do have to, then add a parameter for the path here.
     */
    function getStoredFile(string $recordingName)
    {
        return $this->getRequest("/recordings/stored/{$recordingName}/file");
    }

    /**
     * @param string $recordingName
     * @param string $destinationRecordingName
     * @return StoredRecording|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    function copyStored(string $recordingName, string $destinationRecordingName): StoredRecording
    {
        $response = $this->postRequest("/recordings/stored/{$recordingName}/copy",
            ['destinationRecordingName' => $destinationRecordingName]);
        return $this->jsonMapper->map(json_decode($response->getBody()), new StoredRecording());
    }

    /**
     * @param string $recordingName
     * @return LiveRecording|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    function getLive(string $recordingName): LiveRecording
    {
        $response = $this->getRequest("/recordings/live/{$recordingName}");
        return $this->jsonMapper->map(json_decode($response->getBody()), new LiveRecording());
    }

    /**
     * @param string $recordingName
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function cancel(string $recordingName): void
    {
        $this->deleteRequest("/recordings/live/{$recordingName}");
    }

    /**
     * @param string $recordingName
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function stop(string $recordingName): void
    {
        $this->postRequest("/recordings/live/{$recordingName}/stop");
    }

    /**
     * @param string $recordingName
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function pause(string $recordingName): void
    {
        $this->postRequest("/recordings/live/{$recordingName}/pause");
    }

    /**
     * @param string $recordingName
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function unpause(string $recordingName): void
    {
        $this->deleteRequest("/recordings/live/{$recordingName}/pause");
    }

    /**
     * @param string $recordingName
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function mute(string $recordingName): void
    {
        $this->postRequest("/recordings/live/{$recordingName}/mute");
    }

    /**
     * @param string $recordingName
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function unmute(string $recordingName): void
    {
        $this->deleteRequest("/recordings/live/{$recordingName}/mute");
    }
}