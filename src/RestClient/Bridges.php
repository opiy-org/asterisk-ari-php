<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\RestClient;

use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use NgVoice\AriClient\Models\{Bridge, LiveRecording, Model, Playback};

/**
 * An implementation of the Bridges REST client for the
 * Asterisk REST Interface
 *
 * @see https://wiki.asterisk.org/wiki/display/AST/Asterisk+16+Bridges+REST+API
 *
 * @package NgVoice\AriClient\RestClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Bridges extends AsteriskRestInterfaceClient
{
    /**
     * List all active bridges in Asterisk.
     *
     * @return Bridge[]
     *
     * @throws AsteriskRestInterfaceException When the REST request fails.
     */
    public function list(): array
    {
        return $this->getArrayOfModelInstancesRequest(Bridge::class, '/bridges');
    }

    /**
     * Create a new bridge.
     * This bridge persists until it has been shut down, or Asterisk has been shut down.
     *
     * @param string[] $options The options for the request
     * type: string - Comma separated list of bridge type attributes
     *      (mixing, holding, dtmf_events, proxy_media, video_sfu).
     * bridgeId: string - Unique ID to give to the bridge being created.
     * name: string - Name to give to the bridge being created.
     *
     * @return Bridge|Model
     *
     * @throws AsteriskRestInterfaceException When the REST request fails.
     */
    public function create(array $options = []): Bridge
    {
        return $this->postRequestReturningModel(Bridge::class, '/bridges', $options);
    }

    /**
     * Create a new bridge or updates an existing one.
     * This bridge persists until it has been shut down, or Asterisk has been shut down.
     *
     * @param string $bridgeId Unique ID to give to the bridge being created.
     * @param string[] $options The options for the request
     * type: string - Comma separated list of bridge type attributes
     *      (mixing, holding, dtmf_events, proxy_media, video_sfu) to set.
     * name: string - Set the name of the bridge.
     *
     * @return Bridge|Model
     *
     * @throws AsteriskRestInterfaceException When the REST request fails.
     */
    public function createWithId(string $bridgeId, array $options = []): Bridge
    {
        return $this->postRequestReturningModel(
            Bridge::class,
            "/bridges/{$bridgeId}",
            $options
        );
    }

    /**
     * Get bridge details.
     *
     * @param string $bridgeId Bridge's id
     *
     * @return Bridge|Model
     *
     * @throws AsteriskRestInterfaceException When the REST request fails.
     */
    public function get(string $bridgeId): Bridge
    {
        return $this->getModelRequest(Bridge::class, "/bridges/{$bridgeId}");
    }

    /**
     * Shut down a bridge.
     * If any channels are in this bridge, they will be removed and resume whatever they
     * were doing beforehand.
     *
     * @param string $bridgeId Bridge's id
     *
     * @throws AsteriskRestInterfaceException When the REST request fails.
     */
    public function destroy(string $bridgeId): void
    {
        $this->deleteRequest("/bridges/{$bridgeId}");
    }

    /**
     * Add a channel to a bridge.
     *
     * @param string $bridgeId Bridge's id
     * @param array $channel Ids of channels to add to bridge.
     * @param array $options The options for the request
     * role: string - Channel's role in the bridge
     * absorbDTMF: boolean - Absorb DTMF coming from this channel, preventing it to pass
     *     through to the bridge mute: boolean - Mute audio from this channel, preventing
     *     it to pass through to the bridge
     *
     * @throws AsteriskRestInterfaceException When the REST request fails.
     */
    public function addChannel(
        string $bridgeId,
        array $channel,
        array $options = []
    ): void {
        $this->postRequest(
            "/bridges/{$bridgeId}/addChannel",
            ['channel' => implode(',', $channel)] + $options
        );
    }

    /**
     * Remove a channel from a bridge.
     *
     * @param string $bridgeId Bridge's id
     * @param string[] $channel Ids of channels to remove from bridge
     *
     * @throws AsteriskRestInterfaceException When the REST request fails.
     */
    public function removeChannel(string $bridgeId, array $channel): void
    {
        $this->postRequest(
            "/bridges/{$bridgeId}/removeChannel",
            ['channel' => implode(',', $channel)]
        );
    }

    /**
     * Set a channel as the video source in a multi-party mixing bridge.
     * This operation has no effect on bridges with two or fewer participants.
     *
     * @param string $bridgeId Bridge's id
     * @param string $channelId Channels's id
     *
     * @throws AsteriskRestInterfaceException When the REST request fails.
     */
    public function setVideoSource(string $bridgeId, string $channelId): void
    {
        $this->postRequest("/bridges/{$bridgeId}/videoSource/{$channelId}");
    }

    /**
     * Removes any explicit video source in a multi-party mixing bridge.
     * This operation has no effect on bridges with two or fewer participants.
     * When no explicit video source is set, talk detection will be used to determine the
     * active video stream.
     *
     * @param string $bridgeId Bridge's id
     *
     * @throws AsteriskRestInterfaceException When the REST request fails.
     */
    public function clearVideoSource(string $bridgeId): void
    {
        $this->deleteRequest("/bridges/{$bridgeId}/videoSource");
    }

    /**
     * Play music on hold to a bridge or change the MOH class that is playing.
     *
     * @param string $bridgeId Bridge's id
     * @param string $mohClass Music on hold class
     *
     * @throws AsteriskRestInterfaceException When the REST request fails.
     */
    public function startMoh(string $bridgeId, string $mohClass = ''): void
    {
        $queryParameters = [];
        if ($mohClass !== '') {
            $queryParameters = ['mohClass' => $mohClass];
        }
        $this->postRequest("/bridges/{$bridgeId}/moh", $queryParameters);
    }

    /**
     * Stop playing music on hold to a bridge.
     * This will only stop music on hold being played via POST bridges/{bridgeId}/moh.
     *
     * @param string $bridgeId Bridge's id
     *
     * @throws AsteriskRestInterfaceException When the REST request fails.
     */
    public function stopMoh(string $bridgeId): void
    {
        $this->deleteRequest("/bridges/{$bridgeId}/moh");
    }

    /**
     * Start playback of media on a bridge.
     *
     * The media URI may be any of a number of URI's.
     * Currently sound:, recording:, number:, digits:, characters:, and tone: URI's are
     * supported. This operation creates a playback resource that can be used to control
     * the playback of media (pause, rewind, fast forward, etc.).
     *
     * @param string $bridgeId Bridge's id
     * @param array $media List of media URIs to play.
     * @param array $options The options for the request
     * lang: string - For sounds, selects language for sound.
     * offsetms: int - Number of milliseconds to skip before playing.
     *      Only applies to the first URI if multiple media URIs are specified. Allowed
     *     range: Min: 0; Max: None skipms: int - Number of milliseconds to skip for
     *     forward/reverse operations. Default: 3000. Allowed range: Min: 0; Max: None
     *     playbackId: string - Playback Id.
     *
     * @return Playback|Model
     *
     * @throws AsteriskRestInterfaceException When the REST request fails.
     */
    public function play(string $bridgeId, array $media, array $options = []): Playback
    {
        return $this->postRequestReturningModel(
            Playback::class,
            "/bridges/{$bridgeId}/play",
            ['media' => implode(',', $media)] + $options,
        );
    }

    /**
     * Start playback of media on a bridge.
     * The media URI may be any of a number of URI's.
     * Currently sound:, recording:, number:, digits:, characters:, and tone: URI's are
     * supported. This operation creates a playback resource that can be used to control
     * the playback of media (pause, rewind, fast forward, etc.).
     *
     * @param string $bridgeId Bridge's id
     * @param string $playbackId Playback id
     * @param array $media List of media URI's to play
     * @param array $options The options for the request
     * lang: string - For sounds, selects language for sound.
     * offsetms: int - Number of milliseconds to skip before playing.
     *      Only applies to the first URI if multiple media URIs are specified. Allowed
     *     range: Min: 0; Max: None skipms: int - Number of milliseconds to skip for
     *     forward/reverse operations. Default: 3000. Allowed range: Min: 0; Max: None
     *
     * @return Playback|Model
     *
     * @throws AsteriskRestInterfaceException When the REST request fails.
     */
    public function playWithId(
        string $bridgeId,
        string $playbackId,
        array $media,
        array $options = []
    ): Playback {
        return $this->postRequestReturningModel(
            Playback::class,
            "/bridges/{$bridgeId}/play/{$playbackId}",
            ['media' => implode(',', $media)] + $options,
        );
    }

    /**
     * Start a recording.
     * This records the mixed audio from all channels participating in this bridge.
     *
     * @param string $bridgeId Bridge's id.
     * @param string $name Recording's filename.
     * @param string $format Format to encode audio in.
     * @param array $options The options for the request
     * maxDurationSeconds: int - Maximum duration of the recording, in seconds. 0 for no
     *     limit. Allowed range: Min: 0; Max: None maxSilenceSeconds: int - Maximum
     *     duration of silence, in seconds. 0 for no limit. Allowed range: Min: 0; Max:
     *     None ifExists: string - Action to take if a recording with the same name
     *     already exists. Default: fail. Allowed values: fail, overwrite, append beep:
     *     boolean - Play beep when recording begins terminateOn: string - DTMF input to
     *     terminate recording. Default: none. Allowed values: none, any, *, #
     *
     * @return LiveRecording|Model
     *
     * @throws AsteriskRestInterfaceException When the REST request fails.
     */
    public function record(
        string $bridgeId,
        string $name,
        string $format,
        array $options = []
    ): LiveRecording {
        return $this->postRequestReturningModel(
            LiveRecording::class,
            "/bridges/{$bridgeId}/record",
            ['name' => $name, 'format' => $format] + $options,
        );
    }
}
