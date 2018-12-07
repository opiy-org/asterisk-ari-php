<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\rest_clients;


use AriStasisApp\models\{Bridge, LiveRecording, Playback};
use function AriStasisApp\{glueArrayOfStrings, mapJsonArrayToAriObjects, mapJsonToAriObject};

/**
 * Class Bridges
 *
 * @package AriStasisApp\ariclients
 */
class Bridges extends AriRestClient
{
    /**
     * List all active bridges in Asterisk.
     *
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function list(): array
    {
        return mapJsonArrayToAriObjects(
            $this->getRequest('/bridges'),
            'AriStasisApp\models\Bridge',
            $this->jsonMapper,
            $this->logger
        );
    }

    /**
     * Create a new bridge.
     * This bridge persists until it has been shut down, or Asterisk has been shut down.
     *
     * @param array $type List of bridge type attributes
     * (mixing, holding, dtmf_events, proxy_media, video_sfu).
     * @param string $bridgeId Unique ID to give to the bridge being created.
     * @param string $name Name to give to the bridge being created.
     * @return Bridge|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function create(?array $type, ?string $bridgeId, ?string $name): Bridge
    {
        $queryParameters = [];
        if (!is_null($type)) {
            $queryParameters['type'] = glueArrayOfStrings($type);
        }
        if (!is_null($bridgeId)) {
            $queryParameters['bridgeId'] = $bridgeId;
        }
        if (!is_null($name)) {
            $queryParameters['name'] = $name;
        }

        return mapJsonToAriObject(
            $this->postRequest('/bridges', $queryParameters),
            'AriStasisApp\models\Bridge',
            $this->jsonMapper,
            $this->logger
        );

    }

    /**
     * Create a new bridge or updates an existing one.
     * This bridge persists until it has been shut down, or Asterisk has been shut down.
     *
     * @param string $bridgeId Unique ID to give to the bridge being created.
     * @param array $type List of bridge type attributes
     * (mixing, holding, dtmf_events, proxy_media, video_sfu) to set.
     * @param string $name Set the name of the bridge.
     * @return Bridge|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function createWithId(string $bridgeId, ?array $type, ?string $name): Bridge
    {
        $queryParameters = [];
        if (!is_null($type)) {
            $queryParameters['type'] = glueArrayOfStrings($type);
        }
        if (!is_null($name)) {
            $queryParameters['name'] = $name;
        }

        return mapJsonToAriObject(
            $this->postRequest("/bridges/{$bridgeId}", $queryParameters),
            'AriStasisApp\models\Bridge',
            $this->jsonMapper,
            $this->logger
        );
    }

    /**
     * Get bridge details.
     *
     * @param string $bridgeId Bridge's id
     * @return Bridge|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function get(string $bridgeId): Bridge
    {
        return mapJsonToAriObject(
            $this->getRequest("/bridges/{$bridgeId}"),
            'AriStasisApp\models\Bridge',
            $this->jsonMapper,
            $this->logger
        );
    }

    /**
     * Shut down a bridge.
     * If any channels are in this bridge, they will be removed and resume whatever they were doing beforehand.
     *
     * @param string $bridgeId Bridge's id
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function destroy(string $bridgeId): void
    {
        $this->deleteRequest("/bridges/{$bridgeId}");
    }

    /**
     * Add a channel to a bridge.
     *
     * @param string $bridgeId Bridge's id
     * @param array $channel Ids of channels to add to bridge.
     * @param string $role Channels's role in the bridge.
     * @param bool $absorbDTMF Absorb DTMF coming from this channel, preventing it to pass through to the bridge.
     * @param bool $mute Mute audio from this channel, preventing it to pass through to the bridge.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function addChannel(
        string $bridgeId,
        array $channel,
        ?string $role,
        bool $absorbDTMF = false,
        bool $mute = false
    ): void {
        $queryParameters = ['absorbDTMF' => $absorbDTMF, 'mute' => $mute];
        $queryParameters['channel'] = glueArrayOfStrings($channel);

        if (!is_null($role)) {
            $queryParameters['role'] = $role;
        }

        $this->postRequest("/bridges/{$bridgeId}/addChannel", $queryParameters);
    }

    /**
     * Remove a channel from a bridge.
     *
     * @param string $bridgeId Bridge's id
     * @param array $channel Ids of channels to remove from bridge
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function removeChannel(string $bridgeId, array $channel): void
    {
        $queryParameters = ['channel' => glueArrayOfStrings($channel)];
        $this->postRequest("/bridges/{$bridgeId}/removeChannel", $queryParameters);
    }

    /**
     * Set a channel as the video source in a multi-party mixing bridge.
     * This operation has no effect on bridges with two or fewer participants.
     *
     * @param string $bridgeId Bridge's id
     * @param string $channelId Channels's id
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function setVideoSource(string $bridgeId, string $channelId): void
    {
        $this->postRequest("/bridges/{$bridgeId}/videoSource/{$channelId}");
    }

    /**
     * Removes any explicit video source in a multi-party mixing bridge.
     * This operation has no effect on bridges with two or fewer participants.
     * When no explicit video source is set, talk detection will be used to determine the active video stream.
     *
     * @param string $bridgeId Bridge's id
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function clearVideoSource(string $bridgeId): void
    {
        $this->deleteRequest("/bridges/{$bridgeId}/videoSource");
    }

    /**
     * Play music on hold to a bridge or change the MOH class that is playing.
     *
     * @param string $bridgeId Bridge's id
     * @param string $mohClass Music on hold class
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function startMoh(string $bridgeId, ?string $mohClass): void
    {
        $queryParameters = [];
        if (!is_null($mohClass)) {
            $queryParameters = ['mohClass' => $mohClass];
        }

        $this->postRequest("/bridges/{$bridgeId}/moh", $queryParameters);
    }

    /**
     * Stop playing music on hold to a bridge.
     * This will only stop music on hold being played via POST bridges/{bridgeId}/moh.
     *
     * @param string $bridgeId Bridge's id
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function stopMoh(string $bridgeId): void
    {
        $this->deleteRequest("/bridges/{$bridgeId}/moh");
    }

    /**
     * Start playback of media on a bridge.
     *
     * The media URI may be any of a number of URI's.
     * Currently sound:, recording:, number:, digits:, characters:, and tone: URI's are supported.
     * This operation creates a playback resource that can be used to control the playback
     * of media (pause, rewind, fast forward, etc.).
     *
     * @param string $bridgeId Bridge's id
     * @param array $media List of media URIs to play.
     * @param string $lang For sounds, selects language for sound.
     * @param int $offsetms Number of milliseconds to skip before playing. Only applies to the first
     * URI if multiple media URIs are specified.
     * @param int $skipms Number of milliseconds to skip for forward/reverse operations.
     * @param string $playbackId Playback Id
     * @return Playback|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function play(
        string $bridgeId,
        array $media,
        ?string $lang,
        ?string $playbackId,
        int $offsetms = 0,
        int $skipms = 3000
    ): Playback {
        $queryParameters = [];
        $queryParameters['media'] = glueArrayOfStrings($media);
        $queryParameters['offsetms'] = $offsetms;
        $queryParameters['skipms'] = $skipms;
        if (!is_null($lang)) {
            $queryParameters['lang'] = $lang;
        }
        if (!is_null($playbackId)) {
            $queryParameters['playbackId'] = $playbackId;
        }

        return mapJsonToAriObject(
            $this->postRequest("/bridges/{$bridgeId}/play", $queryParameters),
            'AriStasisApp\models\Playback',
            $this->jsonMapper,
            $this->logger
        );
    }

    /**
     * Start playback of media on a bridge.
     * The media URI may be any of a number of URI's.
     * Currently sound:, recording:, number:, digits:, characters:, and tone: URI's are supported.
     * This operation creates a playback resource that can be used to control the playback
     * of media (pause, rewind, fast forward, etc.).
     *
     * @param string $bridgeId Bridge's id
     * @param string $playbackId Playback id
     * @param array $media List of media URI's to play
     * @param string $lang For sounds, selects language for sound.
     * @param int $offsetms Number of milliseconds to skip before playing.
     * Only applies to the first URI if multiple media URIs are specified.
     * @param int $skipms Number of milliseconds to skip for forward/reverse operations.
     * @return Playback|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function playWithId(
        string $bridgeId,
        string $playbackId,
        array $media,
        ?string $lang,
        int $offsetms = 0,
        int $skipms = 3000
    ): Playback {
        $queryParameters = [];
        $queryParameters['media'] = glueArrayOfStrings($media);
        $queryParameters['offsetms'] = $offsetms;
        $queryParameters['skipms'] = $skipms;
        if (!is_null($lang)) {
            $queryParameters['lang'] = $lang;
        }

        return mapJsonToAriObject(
            $this->postRequest("/bridges/{$bridgeId}/play/{$playbackId}", $queryParameters),
            'AriStasisApp\models\Playback',
            $this->jsonMapper,
            $this->logger
        );
    }

    /**
     * Start a recording.
     * This records the mixed audio from all channels participating in this bridge.
     *
     * @param string $bridgeId Bridge's id.
     * @param string $name Recording's filename.
     * @param string $format Format to encode audio in.
     * @param int $maxDurationSeconds Maximum duration of the recording, in seconds. 0 for no limit.
     * @param int $maxSilenceSeconds Maximum duration of silence, in seconds. 0 for no limit.
     * @param string $ifExists Action to take if a recording with the same name already exists
     * (fail | overwrite | append).
     * @param bool $beep Play beep when recording begins
     * @param string $terminateOn DTMF input to terminate recording (none | any | * | #).
     * @return LiveRecording|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function record(
        string $bridgeId,
        string $name,
        string $format,
        ?string $ifExists,
        ?string $terminateOn,
        int $maxDurationSeconds = 0,
        int $maxSilenceSeconds = 0,
        bool $beep = false
    ): LiveRecording {
        $queryParameters = [];
        $queryParameters['name'] = $name;
        $queryParameters['format'] = $format;
        $queryParameters['maxDurationSeconds'] = $maxDurationSeconds;
        $queryParameters['maxSilenceSeconds'] = $maxSilenceSeconds;
        $queryParameters['beep'] = $beep;
        if (!is_null($ifExists)) {
            $queryParameters['ifExists'] = $ifExists;
        }
        if (!is_null($terminateOn)) {
            $queryParameters['terminateOn'] = $terminateOn;
        }

        return mapJsonToAriObject(
            $this->postRequest("/bridges/{$bridgeId}/record", $queryParameters),
            'AriStasisApp\models\LiveRecording',
            $this->jsonMapper,
            $this->logger
        );
    }
}