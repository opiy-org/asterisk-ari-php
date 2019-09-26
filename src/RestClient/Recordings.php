<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\RestClient;

use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use NgVoice\AriClient\Models\{LiveRecording, StoredRecording};

/**
 * An implementation of the Recordings REST client for the
 * Asterisk REST Interface
 *
 * @see https://wiki.asterisk.org/wiki/display/AST/Asterisk+16+Recordings+REST+API
 *
 * @package NgVoice\AriClient\RestClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Recordings extends AsteriskRestInterfaceClient
{
    /**
     * List recordings that are complete.
     *
     * @return StoredRecording[]
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function listStored()
    {
        /** @var StoredRecording[] $storedRecordings */
        $storedRecordings = $this->requestGetArrayOfModels(
            StoredRecording::class,
            '/recordings/stored'
        );

        return $storedRecordings;
    }

    /**
     * Get a stored recording's details.
     *
     * @param string $recordingName The name of the recording
     *
     * @return StoredRecording
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function getStored(string $recordingName): StoredRecording
    {
        /** @var StoredRecording $storedRecording */
        $storedRecording = $this->getModelRequest(
            StoredRecording::class,
            "/recordings/stored/{$recordingName}"
        );

        return $storedRecording;
    }

    /**
     * Delete a stored recording.
     *
     * @param string $recordingName The name of the recording.
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function deleteStored(string $recordingName): void
    {
        $this->deleteRequest("/recordings/stored/{$recordingName}");
    }

    /**
     * Get the file associated with the stored recording.
     *
     * @param string $recordingName The name of the recording.
     *
     * @param string $pathToFile The full path to the location
     * where the downloaded file shall be saved to.
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function getStoredFile(string $recordingName, string $pathToFile): void
    {
        $this->downloadFile("/recordings/stored/{$recordingName}/file", $pathToFile);
    }

    /**
     * Copy a stored recording.
     *
     * @param string $recordingName The name of the recording to copy.
     * @param string $destinationRecordingName The destination name of the recording.
     *
     * @return StoredRecording
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function copyStored(
        string $recordingName,
        string $destinationRecordingName
    ): StoredRecording {
        /** @var StoredRecording $storedRecording */
        $storedRecording = $this->postRequestReturningModel(
            StoredRecording::class,
            "/recordings/stored/{$recordingName}/copy",
            ['destinationRecordingName' => $destinationRecordingName]
        );

        return $storedRecording;
    }

    /**
     * List live recordings.
     *
     * @param string $recordingName The name of the recording.
     *
     * @return LiveRecording
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function getLive(string $recordingName): LiveRecording
    {
        /** @var LiveRecording $liveRecording */
        $liveRecording = $this->getModelRequest(
            LiveRecording::class,
            "/recordings/live/{$recordingName}"
        );

        return $liveRecording;
    }

    /**
     * Stop a live recording and discard it.
     *
     * @param string $recordingName The name of the recording.
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function cancel(string $recordingName): void
    {
        $this->deleteRequest("/recordings/live/{$recordingName}");
    }

    /**
     * Stop a live recording and store it.
     *
     * @param string $recordingName The name of the recording.
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
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
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function pause(string $recordingName): void
    {
        $this->postRequest("/recordings/live/{$recordingName}/pause");
    }

    /**
     * Unpause a live recording.
     *
     * @param string $recordingName The name of the recording.
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
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
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function mute(string $recordingName): void
    {
        $this->postRequest("/recordings/live/{$recordingName}/mute");
    }

    /**
     * Unmute a live recording.
     *
     * @param string $recordingName The name of the recording.
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function unmute(string $recordingName): void
    {
        $this->deleteRequest("/recordings/live/{$recordingName}/mute");
    }
}
