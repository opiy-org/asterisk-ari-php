<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\rest_clients;


use AriStasisApp\models\LiveRecording;
use AriStasisApp\models\StoredRecording;
use GuzzleHttp\Psr7\Response;

/**
 * Class Recordings
 *
 * @package AriStasisApp\rest_clients
 */
class Recordings extends AriRestClient
{
    private const STORED_RECORDING = 'StoredRecording';

    /**
     * List recordings that are complete.
     *
     * @return StoredRecording[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function listStored(): array
    {
        return $this->getRequest('/recordings/stored', [], 'array', self::STORED_RECORDING);
    }

    /**
     * Get a stored recording's details.
     *
     * @param string $recordingName The name of the recording
     * @return StoredRecording|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function getStored(string $recordingName): StoredRecording
    {
        return $this->getRequest("/recordings/stored/{$recordingName}", [], self::MODEL, self::STORED_RECORDING);
    }

    /**
     * Delete a stored recording.
     *
     * @param string $recordingName The name of the recording.
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function deleteStored(string $recordingName): void
    {
        $this->deleteRequest("/recordings/stored/{$recordingName}");
    }

    /**
     * Get the file associated with the stored recording.
     *
     * @param string $recordingName The name of the recording.
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function getStoredFile(string $recordingName): Response
    {
        return $this->getRequest("/recordings/stored/{$recordingName}/file");
    }

    /**
     * Copy a stored recording.
     *
     * @param string $recordingName The name of the recording to copy.
     * @param string $destinationRecordingName The destination name of the recording.
     * @return StoredRecording|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function copyStored(string $recordingName, string $destinationRecordingName): StoredRecording
    {
        return $this->postRequest("/recordings/stored/{$recordingName}/copy",
            ['destinationRecordingName' => $destinationRecordingName], [], self::MODEL, self::STORED_RECORDING);
    }

    /**
     * List live recordings.
     *
     * @param string $recordingName The name of the recording.
     * @return LiveRecording|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function getLive(string $recordingName): LiveRecording
    {
        return $this->getRequest("/recordings/live/{$recordingName}", [], self::MODEL, 'LiveRecording');
    }

    /**
     * Stop a live recording and discard it.
     *
     * @param string $recordingName The name of the recording.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function cancel(string $recordingName): void
    {
        $this->deleteRequest("/recordings/live/{$recordingName}");
    }

    /**
     * Stop a live recording and store it.
     *
     * @param string $recordingName The name of the recording.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function stop(string $recordingName): void
    {
        $this->postRequest("/recordings/live/{$recordingName}/stop");
    }

    /**
     * Pause a live recording. Pausing a recording suspends silence detection,
     * which will be restarted when the recording is unpaused. Paused time is not
     * included in the accounting for maxDurationSeconds.
     *
     * @param string $recordingName The name of the recording.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function pause(string $recordingName): void
    {
        $this->postRequest("/recordings/live/{$recordingName}/pause");
    }

    /**
     * Unpause a live recording.
     *
     * @param string $recordingName The name of the recording.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function unpause(string $recordingName): void
    {
        $this->deleteRequest("/recordings/live/{$recordingName}/pause");
    }

    /**
     * Mute a live recording. Muting a recording suspends silence detection,
     * which will be restarted when the recording is unmuted.
     *
     * @param string $recordingName The name of the recording.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function mute(string $recordingName): void
    {
        $this->postRequest("/recordings/live/{$recordingName}/mute");
    }

    /**
     * Unmute a live recording.
     *
     * @param string $recordingName The name of the recording.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function unmute(string $recordingName): void
    {
        $this->deleteRequest("/recordings/live/{$recordingName}/mute");
    }
}