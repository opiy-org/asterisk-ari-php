<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\RestClient;


use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use NgVoice\AriClient\Model\{LiveRecording, StoredRecording};

/**
 * Class Recordings
 * @package NgVoice\AriClient\RestClient
 */
class Recordings extends AriRestClient
{
    /**
     * List recordings that are complete.
     *
     * @return StoredRecording[]
     * @throws GuzzleException
     */
    public function listStored(): array
    {
        return $this->getRequest('/recordings/stored', [], parent::ARRAY, StoredRecording::class);
    }

    /**
     * Get a stored recording's details.
     *
     * @param string $recordingName The name of the recording
     * @return StoredRecording|object
     * @throws GuzzleException
     */
    public function getStored(string $recordingName): StoredRecording
    {
        return $this->getRequest("/recordings/stored/{$recordingName}", [], parent::MODEL, StoredRecording::class);
    }

    /**
     * Delete a stored recording.
     *
     * @param string $recordingName The name of the recording.
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * @throws GuzzleException
     */
    public function deleteStored(string $recordingName): void
    {
        $this->deleteRequest("/recordings/stored/{$recordingName}");
    }

    /**
     * Get the file associated with the stored recording.
     *
     * @param string $recordingName The name of the recording.
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws GuzzleException
     */
    public function getStoredFile(string $recordingName): Response
    {
        return $this->getRequest("/recordings/stored/{$recordingName}/file");
    }

    /**
     * Copy a stored recording.
     *
     * @param string $recordingName The name of the recording to copy.
     * @param string $destinationRecordingName The destination name of the recording.
     * @return StoredRecording|object
     * @throws GuzzleException
     */
    public function copyStored(string $recordingName, string $destinationRecordingName): StoredRecording
    {
        return $this->postRequest("/recordings/stored/{$recordingName}/copy",
            ['destinationRecordingName' => $destinationRecordingName], [], parent::MODEL, StoredRecording::class);
    }

    /**
     * List live recordings.
     *
     * @param string $recordingName The name of the recording.
     * @return LiveRecording|object
     * @throws GuzzleException
     */
    public function getLive(string $recordingName): LiveRecording
    {
        return $this->getRequest("/recordings/live/{$recordingName}", [], parent::MODEL, LiveRecording::class);
    }

    /**
     * Stop a live recording and discard it.
     *
     * @param string $recordingName The name of the recording.
     * @throws GuzzleException
     */
    public function cancel(string $recordingName): void
    {
        $this->deleteRequest("/recordings/live/{$recordingName}");
    }

    /**
     * Stop a live recording and store it.
     *
     * @param string $recordingName The name of the recording.
     * @throws GuzzleException
     */
    public function stop(string $recordingName): void
    {
        $this->postRequest("/recordings/live/{$recordingName}/stop");
    }

    /**
     * Pause a live recording. Pausing a recording suspends silence detection,
     * which will be restarted when the recording is unpaused. Paused time is not
     * included in the accounting for maxDurationSeconds.
     *
     * @param string $recordingName The name of the recording.
     * @throws GuzzleException
     */
    public function pause(string $recordingName): void
    {
        $this->postRequest("/recordings/live/{$recordingName}/pause");
    }

    /**
     * Unpause a live recording.
     *
     * @param string $recordingName The name of the recording.
     * @throws GuzzleException
     */
    public function unpause(string $recordingName): void
    {
        $this->deleteRequest("/recordings/live/{$recordingName}/pause");
    }

    /**
     * Mute a live recording. Muting a recording suspends silence detection,
     * which will be restarted when the recording is unmuted.
     *
     * @param string $recordingName The name of the recording.
     * @throws GuzzleException
     */
    public function mute(string $recordingName): void
    {
        $this->postRequest("/recordings/live/{$recordingName}/mute");
    }

    /**
     * Unmute a live recording.
     *
     * @param string $recordingName The name of the recording.
     * @throws GuzzleException
     */
    public function unmute(string $recordingName): void
    {
        $this->deleteRequest("/recordings/live/{$recordingName}/mute");
    }
}