<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Client\Rest\Resource;

use JsonException;
use OpiyOrg\AriClient\Client\Rest\AbstractRestClient;
use OpiyOrg\AriClient\Enum\HttpMethods;
use OpiyOrg\AriClient\Exception\AsteriskRestInterfaceException;
use OpiyOrg\AriClient\Model\{LiveRecording, StoredRecording};

/**
 * An implementation of the Recordings REST client for the
 * Asterisk REST Interface
 *
 * @see https://wiki.asterisk.org/wiki/display/AST/Asterisk+16+Recordings+REST+API
 *
 * @package OpiyOrg\AriClient\Client\Rest\Resource
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class Recordings extends AbstractRestClient
{
    /**
     * List recordings that are complete.
     *
     * @return StoredRecording[]
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     * @throws JsonException
     */
    public function listStored(): array
    {
        $response = $this->sendRequest(HttpMethods::GET, '/recordings/stored');

        /** @var StoredRecording[] $storedRecordings */
        $storedRecordings = [];
        $this->responseToArrayOfAriModelInstances(
            $response,
            new StoredRecording(),
            $storedRecordings
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
     * @throws JsonException
     */
    public function getStored(string $recordingName): StoredRecording
    {
        $response = $this->sendRequest(
            HttpMethods::GET,
            "/recordings/stored/{$recordingName}"
        );

        $storedRecording = new StoredRecording();
        $this->responseToAriModelInstance($response, $storedRecording);

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
        $this->sendRequest(
            HttpMethods::DELETE,
            "/recordings/stored/{$recordingName}"
        );
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
        $this->sendDownloadFileRequest(
            "/recordings/stored/{$recordingName}/file",
            $pathToFile
        );
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
     * @throws JsonException
     */
    public function copyStored(
        string $recordingName,
        string $destinationRecordingName
    ): StoredRecording {
        $response = $this->sendRequest(
            HttpMethods::POST,
            "/recordings/stored/{$recordingName}/copy",
            ['destinationRecordingName' => $destinationRecordingName]
        );

        $storedRecording = new StoredRecording();
        $this->responseToAriModelInstance($response, $storedRecording);

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
     * @throws JsonException
     */
    public function getLive(string $recordingName): LiveRecording
    {
        $response = $this->sendRequest(
            HttpMethods::GET,
            "/recordings/live/{$recordingName}"
        );

        $liveRecording = new LiveRecording();
        $this->responseToAriModelInstance($response, $liveRecording);

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
        $this->sendRequest(
            HttpMethods::DELETE,
            "/recordings/live/{$recordingName}"
        );
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
        $this->sendRequest(
            HttpMethods::POST,
            "/recordings/live/{$recordingName}/stop"
        );
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
        $this->sendRequest(
            HttpMethods::POST,
            "/recordings/live/{$recordingName}/pause"
        );
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
        $this->sendRequest(
            HttpMethods::DELETE,
            "/recordings/live/{$recordingName}/pause"
        );
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
        $this->sendRequest(
            HttpMethods::POST,
            "/recordings/live/{$recordingName}/mute"
        );
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
        $this->sendRequest(
            HttpMethods::DELETE,
            "/recordings/live/{$recordingName}/mute"
        );
    }
}
