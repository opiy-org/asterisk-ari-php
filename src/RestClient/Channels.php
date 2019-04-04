<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\RestClient;

use GuzzleHttp\Exception\GuzzleException;
use NgVoice\AriClient\Model\{Channel, LiveRecording, Playback, Variable};
use function NgVoice\AriClient\glueArrayOfStrings;


/**
 * Class Channels
 * @package NgVoice\AriClient\RestClient
 */
final class Channels extends AriRestClient
{
    private const ENDPOINT = 'endpoint';

    /**
     * List all active channels in Asterisk.
     *
     * @return Channel[]|object
     * @throws GuzzleException
     */
    public function list(): array
    {
        return $this->getRequest('/channels', [], parent::ARRAY, Channel::class);
    }

    /**
     * Create a new channel (originate).
     * The new channel is created immediately and a snapshot of it returned.
     * If a Stasis application is provided it will be automatically subscribe
     * to the originated channel for further events and updates.
     *
     * @param string $endpoint e.g. SIP/alice
     * @param array $options
     * extension: string - The extension to dial after the endpoint answers. Mutually exclusive with 'app'.
     * context: string - The context to dial after the endpoint answers. If omitted, uses 'default'.
     *      Mutually exclusive with 'app'.
     * priority: long - The priority to dial after the endpoint answers.
     *      If omitted, uses 1. Mutually exclusive with 'app'.
     * label: string - The label to dial after the endpoint answers.
     *      Will supersede 'priority' if provided. Mutually exclusive with 'app'.
     * app: string - The application that is subscribed to the originated channel.
     *      When the channel is answered, it will be passed to this Stasis application.
     *      Mutually exclusive with 'context', 'extension', 'priority', and 'label'.
     * appArgs: string - The application arguments to pass to the Stasis application provided by 'app'.
     *      Mutually exclusive with 'context', 'extension', 'priority', and 'label'.
     * callerId: string - CallerID to use when dialing the endpoint or extension.
     * timeout: int - Timeout (in seconds) before giving up dialing, or -1 for no timeout. Default: 30
     * channelId: string - The unique id to assign the channel on creation.
     * otherChannelId: string - The unique id to assign the second channel when using local channels.
     * originator: string - The unique id of the channel which is originating this one.
     * formats: string - The format name capability list to use if originator is not specified.
     *      Ex. "ulaw,slin16". Format names can be found with "core show codecs".
     * @param string[] $channelVariables
     * @return Channel|object
     * @throws GuzzleException
     */
    public function originate(string $endpoint, array $options = [], array $channelVariables = []): Channel
    {
        return $this->postRequest(
            '/channels',
            [self::ENDPOINT => $endpoint] + $options,
            ['variables' => $channelVariables],
            parent::MODEL,
            Channel::class
        );
    }

    /**
     * Create channel.
     *
     * @param string $endpoint Endpoint for channel communication
     * @param string $app Stasis Application to place channel into
     * @param string[] $options
     * appArgs: string - The application arguments to pass to the Stasis application provided by 'app'.
     *      Mutually exclusive with 'context', 'extension', 'priority', and 'label'.
     * channelId: string - The unique id to assign the channel on creation.
     * otherChannelId: string - The unique id to assign the second channel when using local channels.
     * originator: string - Unique ID of the calling channel
     * formats: string - The format name capability list to use if originator is not specified.
     *      Ex. "ulaw,slin16". Format names can be found with "core show codecs".
     * @return Channel|object
     * @throws GuzzleException
     */
    public function create(string $endpoint, string $app, array $options = []): Channel
    {
        return $this->postRequest(
            '/channels/create',
            [self::ENDPOINT => $endpoint, 'app' => $app] + $options,
            [],
            parent::MODEL,
            Channel::class
        );
    }

    /**
     * Channel details.
     *
     * @param string $channelId Channel's id.
     * @return Channel|object
     * @throws GuzzleException
     */
    public function get(string $channelId): Channel
    {
        return $this->getRequest(
            "/channels/{$channelId}",
            [],
            parent::MODEL,
            Channel::class
        );
    }

    /**
     * Create a new channel (originate with id).
     * The new channel is created immediately and a snapshot of it returned.
     * If a Stasis application is provided it will be automatically subscribed
     * to the originated channel for further events and updates.
     *
     * @param string $channelId The unique id to assign the channel on creation.
     * @param string $endpoint Endpoint to call.
     * @param array $options
     * extension: string - The extension to dial after the endpoint answers. Mutually exclusive with 'app'.
     * context: string - The context to dial after the endpoint answers. If omitted, uses 'default'.
     *      Mutually exclusive with 'app'.
     * priority: long - The priority to dial after the endpoint answers. If omitted, uses 1.
     *      Mutually exclusive with 'app'.
     * label: string - The label to dial after the endpoint answers. Will supersede 'priority' if provided.
     *      Mutually exclusive with 'app'.
     * app: string - The application that is subscribed to the originated channel.
     *      When the channel is answered, it will be passed to this Stasis application.
     *      Mutually exclusive with 'context', 'extension', 'priority', and 'label'.
     * appArgs: string - The application arguments to pass to the Stasis application provided by 'app'.
     *      Mutually exclusive with 'context', 'extension', 'priority', and 'label'.
     * callerId: string - CallerID to use when dialing the endpoint or extension.
     * timeout: int - Timeout (in seconds) before giving up dialing, or -1 for no timeout. Default: 30
     * otherChannelId: string - The unique id to assign the second channel when using local channels.
     * originator: string - The unique id of the channel which is originating this one.
     * formats: string - The format name capability list to use if originator is not specified.
     *      Ex. "ulaw,slin16". Format names can be found with "core show codecs" in Asterisk.
     * @param string[] $channelVariables
     * @return Channel|object
     * @throws GuzzleException
     */
    public function originateWithId(
        string $channelId,
        string $endpoint,
        array $options = [],
        array $channelVariables = []
    ): Channel {
        return $this->postRequest(
            "/channels/{$channelId}",
            [self::ENDPOINT => $endpoint] + $options,
            ['variables' => $channelVariables],
            parent::MODEL,
            Channel::class
        );
    }

    /**
     * Delete (i.e. hangup) a channel.
     *
     * @param string $channelId Channel's id.
     * @param string $reason Reason for hanging up the channel.
     * Allowed values: normal, busy, congestion, no_answer, timeout, rejected, unallocated, normal_unspecified,
     * number_incomplete, codec_mismatch, interworking, failure, answered_elsewhere
     * @throws GuzzleException
     */
    public function hangup(string $channelId, string $reason = ''): void
    {
        $queryParameters = [];

        if ($reason !== '') {
            $queryParameters['reason'] = $reason;
        }

        $this->deleteRequest("/channels/{$channelId}", $queryParameters);
    }

    /**
     * Exit application; continue execution in the dialplan.
     *
     * @param string $channelId Channel's id.
     * @param string[] $options
     * context: string - The context to continue to.
     * extension: string - The extension to continue to.
     * priority: int - The priority to continue to.
     * label: string - The label to continue to - will supersede 'priority' if both are provided.
     * @throws GuzzleException
     */
    public function continueInDialPlan(string $channelId, array $options): void
    {
        $this->postRequest("/channels/{$channelId}/continue", $options);
    }

    /**
     * Move the channel from one Stasis application to another.
     *
     * @param string $channelId Channel's id
     * @param string $app The channel will be passed to this Stasis application.
     * @param string[] $appArgs The application arguments to pass to the Stasis application provided by 'app'.
     * @throws GuzzleException
     */
    public function move(string $channelId, string $app, array $appArgs = []): void
    {
        $queryParameters = ['app' => $app];

        if ($appArgs !== []) {
            $queryParameters['appArgs'] = glueArrayOfStrings($appArgs);
        }

        $this->postRequest("/channels/{$channelId}/move", $queryParameters);
    }

    /**
     * Redirect the channel to a different location.
     *
     * @param string $channelId Channel's id.
     * @param string $endpoint The endpoint to redirect the channel to.
     * @throws GuzzleException
     */
    public function redirect(string $channelId, string $endpoint): void
    {
        $this->postRequest("/channels/{$channelId}/redirect", [self::ENDPOINT => $endpoint]);
    }

    /**
     * Answer a channel.
     *
     * @param string $channelId Channel's id.
     * @throws GuzzleException
     */
    public function answer(string $channelId): void
    {
        $this->postRequest("/channels/{$channelId}/answer");
    }

    /**
     * Indicate ringing to a channel.
     *
     * @param string $channelId Channel's id.
     * @throws GuzzleException
     */
    public function ring(string $channelId): void
    {
        $this->postRequest("/channels/{$channelId}/ring");
    }

    /**
     * Stop ringing indication on a channel if locally generated.
     *
     * @param string $channelId Channel's id.
     * @throws GuzzleException
     */
    public function ringStop(string $channelId): void
    {
        $this->deleteRequest("/channels/{$channelId}/ring");
    }

    /**
     * Send provided DTMF to a given channel.
     *
     * @param string $channelId Channel's id.
     * @param string $dtmf DTMF To send.
     * @param array $options
     * before: int - Amount of time to wait before DTMF digits (specified in milliseconds) start.
     * between: int - Amount of time in between DTMF digits (specified in milliseconds). Default: 100
     * duration: int - Length of each DTMF digit (specified in milliseconds). Default: 100
     * after: int - Amount of time to wait after DTMF digits (specified in milliseconds) end.
     * @throws GuzzleException
     */
    public function sendDtmf(string $channelId, string $dtmf, array $options = []): void
    {
        $this->postRequest("/channels/{$channelId}/dtmf", ['dtmf' => $dtmf] + $options);
    }

    /**
     * Mute a channel.
     *
     * @param string $channelId Channel's id.
     * @param string $direction Direction in which to mute audio (both, in, out).
     * @throws GuzzleException
     */
    public function mute(string $channelId, string $direction = 'both'): void
    {
        $this->postRequest("/channels/{$channelId}/mute", ['direction' => $direction]);
    }

    /**
     * Unmute a channel.
     *
     * @param string $channelId Channel's id.
     * @param string $direction Direction in which to unmute audio (both, in, out).
     * @throws GuzzleException
     */
    public function unMute(string $channelId, string $direction = 'both'): void
    {
        $this->deleteRequest("/channels/{$channelId}/mute", ['direction' => $direction]);
    }

    /**
     * Hold a channel.
     *
     * @param string $channelId Channel's id.
     * @throws GuzzleException
     */
    public function hold(string $channelId): void
    {
        $this->postRequest("/channels/{$channelId}/hold");
    }

    /**
     * Remove a channel from hold.
     *
     * @param string $channelId Channel's id.
     * @throws GuzzleException
     */
    public function unHold(string $channelId): void
    {
        $this->deleteRequest("/channels/{$channelId}/hold");
    }

    /**
     * Play music on hold to a channel. Using media operations such as /play on a channel
     * playing MOH in this manner will suspend MOH without resuming automatically.
     * If continuing music on hold is desired, the stasis application must reinitiate music on hold.
     *
     * @param string $channelId Channel's id.
     * @param string $mohClass Music on hold class to use.
     * @throws GuzzleException
     */
    public function startMoh(string $channelId, string $mohClass = ''): void
    {
        $queryParameters = [];

        if ($mohClass !== '') {
            $queryParameters['mohClass'] = $mohClass;
        }

        $this->postRequest("/channels/{$channelId}/moh", $queryParameters);
    }

    /**
     * Stop playing music on hold to a channel.
     *
     * @param string $channelId Channel's id.
     * @throws GuzzleException
     */
    public function stopMoh(string $channelId): void
    {
        $this->deleteRequest("/channels/{$channelId}/moh");
    }

    /**
     * Play silence to a channel. Using media operations such as /play on a channel playing
     * silence in this manner will suspend silence without resuming automatically.
     *
     * @param string $channelId Channel's id.
     * @throws GuzzleException
     */
    public function startSilence(string $channelId): void
    {
        $this->postRequest("/channels/{$channelId}/silence");
    }

    /**
     * Play silence to a channel. Using media operations such as /play on a channel
     * playing silence in this manner will suspend silence without resuming automatically.
     *
     * @param string $channelId Channel's id
     * @throws GuzzleException
     */
    public function stopSilence(string $channelId): void
    {
        $this->deleteRequest("/channels/{$channelId}/silence");
    }

    /**
     * Start playback of media. The media URI may be any of a number of URI's.
     * Currently sound:, recording:, number:, digits:, characters:, and tone: URI's are supported.
     * This operation creates a playback resource that can be used to control the playback of media
     * (pause, rewind, fast forward, etc.).
     *
     * @param string $channelId Channel's id.
     * @param string[] $media Media URIs to play.
     * @param array $options
     * lang: string - For sounds, selects language for sound.
     * offsetms: int - Number of milliseconds to skip before playing.
     *      Only applies to the first URI if multiple media URIs are specified.
     * skipms: int - Number of milliseconds to skip for forward/reverse operations. Default: 3000
     * playbackId: string - Playback ID.
     * @return Playback|object
     * @throws GuzzleException
     */
    public function play(string $channelId, array $media, array $options = []): Playback
    {
        return $this->postRequest(
            "/channels/{$channelId}/play",
            ['media' => glueArrayOfStrings($media)] + $options,
            [],
            parent::MODEL,
            Playback::class
        );
    }

    /**
     * Start playback of media and specify the playbackId.
     * The media URI may be any of a number of URI's.
     * Currently sound:, recording:, number:, digits:, characters:, and tone: URI's are supported.
     * This operation creates a playback resource that can be used to control the playback of media
     * (pause, rewind, fast forward, etc.)
     *
     * @param string $channelId Channel's id.
     * @param string $playbackId Playback ID.
     * @param string[] $media Media URIs to play.
     * @param array $options
     * lang: string - For sounds, selects language for sound.
     * offsetms: int - Number of milliseconds to skip before playing.
     *      Only applies to the first URI if multiple media URIs are specified.
     * skipms: int - Number of milliseconds to skip for forward/reverse operations. Default: 3000
     * @return Playback|object
     * @throws GuzzleException
     */
    public function playWithId(string $channelId, string $playbackId, array $media, array $options = []): Playback
    {
        return $this->postRequest(
            "/channels/{$channelId}/play/{$playbackId}",
            ['media' => glueArrayOfStrings($media)] + $options,
            [],
            parent::MODEL,
            Playback::class
        );
    }

    /**
     * Start a recording. Record audio from a channel.
     * Note that this will not capture audio sent to the channel.
     * The bridge itself has a record feature if that's what you want.
     *
     * @param string $channelId Channel's id.
     * @param string $name Recording's filename.
     * @param string $format Format to encode audio in.
     * @param array $options
     * maxDurationSeconds: int - Maximum duration of the recording, in seconds. 0 for no limit.
     *      Allowed range: Min: 0; Max: None
     * maxSilenceSeconds: int - Maximum duration of silence, in seconds. 0 for no limit.
     *      Allowed range: Min: 0; Max: None
     * ifExists: string - Action to take if a recording with the same name already exists. Default: fail
     *      Allowed values: fail, overwrite, append
     * beep: boolean - Play beep when recording begins
     * terminateOn: string - DTMF input to terminate recording. Default: none. Allowed values: none, any, *, #
     * @return LiveRecording|object
     * @throws GuzzleException
     */
    public function record(string $channelId, string $name, string $format, array $options = []): LiveRecording
    {
        return $this->postRequest(
            "/channels/{$channelId}/record",
            ['name' => $name, 'format' => $format] + $options,
            [],
            parent::MODEL,
            LiveRecording::class
        );
    }

    /**
     * Get the value of a channel variable or function.
     *
     * @param string $channelId Channel's id.
     * @param string $variable The channel variable or function to get.
     * @return Variable|object
     * @throws GuzzleException
     */
    public function getChannelVar(string $channelId, string $variable): Variable
    {
        return $this->getRequest(
            "/channels/{$channelId}/variable",
            ['variable' => $variable],
            parent::MODEL,
            Variable::class
        );
    }

    /**
     * Set the value of a channel variable or function.
     *
     * @param string $channelId Channel's id.
     * @param string $variable The channel variable or function to set
     * @param string $value The value to set the variable to
     * @throws GuzzleException
     */
    public function setChannelVar(string $channelId, string $variable, string $value): void
    {
        $this->postRequest("/channels/{$channelId}/variable", [], ['variable' => $variable, 'value' => $value]);
    }

    /**
     * Start snooping. Snoop (spy/whisper) on a specific channel.
     *
     * @param string $channelId Channel's id.
     * @param string $app Application the snooping channel is placed into.
     * @param string[] $options
     * spy: string - Direction of audio to spy on. Default: none. Allowed values: none, both, out, in
     * whisper: string - Direction of audio to whisper into. Default: none. Allowed values: none, both, out, in
     * appArgs: string - The application arguments to pass to the Stasis application
     * snoopId: string - Unique ID to assign to snooping channel
     * @return Channel|object
     * @throws GuzzleException
     */
    public function snoopChannel(string $channelId, string $app, array $options = []): Channel
    {
        return $this->postRequest(
            "/channels/{$channelId}/snoop",
            ['app' => $app] + $options,
            [],
            parent::MODEL,
            Channel::class
        );
    }

    /**
     * Start snooping. Snoop (spy/whisper) on a specific channel.
     *
     * @param string $channelId Channel's id.
     * @param string $snoopId Unique ID to assign to snooping channel.
     * @param string $app Application the snooping channel is placed into.
     * @param string[] $options
     * spy: string - Direction of audio to spy on. Default: 'none'. Allowed values: none, both, out, in
     * whisper: string - Direction of audio to whisper into. Default: none. Allowed values: none, both, out, in
     * appArgs: string - The application arguments to pass to the Stasis application
     * @return Channel|object
     * @throws GuzzleException
     */
    public function snoopChannelWithId(string $channelId, string $snoopId, string $app, array $options = []): Channel
    {
        return $this->postRequest(
            "/channels/{$channelId}/snoop/{$snoopId}",
            ['app' => $app] + $options,
            [],
            parent::MODEL,
            Channel::class
        );
    }

    /**
     * Dial a created channel.
     *
     * @param string $channelId Channel's id
     * @param string $caller Channel ID of caller
     * @param int $timeout Dial timeout. Allowed range: Min: 0; Max: None
     * @throws GuzzleException
     */
    public function dial(string $channelId, string $caller, int $timeout): void
    {
        $this->postRequest("/channels/{$channelId}/dial", ['caller' => $caller, 'timeout' => $timeout]);
    }
}