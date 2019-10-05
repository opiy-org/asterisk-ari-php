<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\RestClient;

use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use NgVoice\AriClient\Models\{Channel,
    ExternalMedia,
    LiveRecording,
    Playback,
    RTPstat,
    Variable};

/**
 * An implementation of the Channels REST client for the
 * Asterisk REST Interface
 *
 * @see https://wiki.asterisk.org/wiki/display/AST/Asterisk+16+Channels+REST+API
 *
 * @package NgVoice\AriClient\RestClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Channels extends AsteriskRestInterfaceClient
{
    private const ENDPOINT = 'endpoint';

    /**
     * List all active channels in Asterisk.
     *
     * @return Channel[]
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function list()
    {
        /** @var Channel[] $channels */
        $channels = $this->requestGetArrayOfModels(Channel::class, '/channels');

        return $channels;
    }

    /**
     * Create a new channel (originate).
     * The new channel is created immediately and a snapshot of it returned.
     * If a Stasis application is provided it will be automatically subscribe
     * to the originated channel for further events and updates.
     *
     * @param string $endpoint e.g. SIP/alice
     * @param array $options A collection of options for the call.
     * extension: string - The extension to dial after the endpoint answers. Mutually
     *     exclusive with 'app'.
     * context: string - The context to dial after the endpoint answers.
     *     If omitted, uses 'default'. Mutually exclusive with 'app'.
     * priority: long - The priority to dial after the endpoint answers.
     *     If omitted, uses 1. Mutually exclusive with 'app'.
     * label: string - The label to dial after the endpoint answers. Will supersede
     *     'priority' if provided. Mutually exclusive with 'app'.
     * app: string - The application that is subscribed to the originated channel.
     *     When the channel is answered, it will be passed to this Stasis application.
     *     Mutually exclusive with 'context', 'extension', 'priority', and 'label'.
     * appArgs: string - The application arguments to pass to the Stasis application
     *     provided by 'app'. Mutually exclusive with 'context', 'extension', 'priority',
     *     and 'label'.
     * callerId: string - CallerID to use when dialing the endpoint or extension.
     * timeout: int - Timeout (in seconds) before giving up dialing, or -1 for no timeout.
     *     Default: 30
     * channelId: string - The unique id to assign the channel on creation.
     * otherChannelId: string - The unique id to assign the second channel when using
     *     local channels.
     * originator: string - The unique id of the channel which is originating this one.
     * formats: string - The format name capability list to use if originator is not
     *     specified. Ex. "ulaw,slin16". Format names can be found with
     *     "core show codecs".
     *
     * @param string[] $channelVariables Variables to be set before the channel is
     *     originated.
     *
     * @return Channel
     *
     * @throws AsteriskRestInterfaceException  in case the REST request fails.
     */
    public function originate(
        string $endpoint,
        array $options,
        array $channelVariables = []
    ): Channel {
        /** @var Channel $channel */
        $channel = $this->postRequestReturningModel(
            Channel::class,
            '/channels',
            [self::ENDPOINT => $endpoint] + $options,
            ['variables' => $channelVariables]
        );

        return $channel;
    }

    /**
     * Create channel.
     *
     * @param string $endpoint Endpoint for channel communication
     * @param string $app Stasis Application to place channel into
     * @param string[] $options A collection of options when creating a channel.
     * appArgs: string - The application arguments to pass to the Stasis application
     *     provided by 'app'. Mutually exclusive with 'context', 'extension', 'priority',
     *     and 'label'.
     * channelId: string - The unique id to assign the channel on creation.
     * otherChannelId: string - The unique id to assign the second channel when using
     *     local channels.
     * originator: string - Unique ID of the calling channel.
     * formats: string - The format name capability list to use if originator is not
     *     specified. Ex. "ulaw,slin16". Format names can be found with "core show
     *     codecs".
     *
     * @return Channel
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function create(string $endpoint, string $app, array $options = []): Channel
    {
        /** @var Channel $channel */
        $channel = $this->postRequestReturningModel(
            Channel::class,
            '/channels/create',
            [self::ENDPOINT => $endpoint, 'app' => $app] + $options
        );

        return $channel;
    }

    /**
     * Channel details.
     *
     * @param string $channelId Channel's id.
     *
     * @return Channel
     *
     * @throws AsteriskRestInterfaceException  in case the REST request fails.
     */
    public function get(string $channelId): Channel
    {
        /** @var Channel $channel */
        $channel = $this->getModelRequest(Channel::class, "/channels/{$channelId}");

        return $channel;
    }

    /**
     * Create a new channel (originate with id).
     * The new channel is created immediately and a snapshot of it returned.
     * If a Stasis application is provided it will be automatically subscribed
     * to the originated channel for further events and updates.
     *
     * @param string $channelId The unique id to assign the channel on creation.
     * @param string $endpoint Endpoint to call.
     * @param array $options A collection of options when originating a channel.
     * extension: string - The extension to dial after the endpoint answers. Mutually
     *     exclusive with 'app'.
     * context: string - The context to dial after the endpoint answers. If omitted, uses
     *     'default'. Mutually exclusive with 'app'.
     * priority: long - The priority to dial after the endpoint answers. If omitted,
     *     uses 1. Mutually exclusive with 'app'.
     * label: string - The label to dial after the endpoint answers. Will supersede
     *     'priority' if provided. Mutually exclusive with 'app'.
     * app: string - The application that is subscribed to the originated channel.
     *     When the channel is answered, it will be passed to this Stasis
     *     application. Mutually exclusive with 'context', 'extension', 'priority', and
     *     'label'.
     * appArgs: string - The application arguments to pass to the Stasis application
     *     provided by 'app'. Mutually exclusive with 'context', 'extension', 'priority',
     *     and 'label'.
     * callerId: string - CallerID to use when dialing the endpoint or extension.
     * timeout: int - Timeout (in seconds) before giving up dialing, or -1 for no timeout.
     *     Default: 30
     * otherChannelId: string - The unique id to assign the second channel when using
     *     local channels.
     * originator: string - The unique id of the channel which is originating this one.
     * formats: string - The format name capability list to use if originator is not
     *     specified. Ex. "ulaw,slin16". Format names can be found with "core show codecs"
     *     in Asterisk.
     * @param string[] $channelVariables Variables to be set before the channel is
     *     originated.
     *
     * @return Channel
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function originateWithId(
        string $channelId,
        string $endpoint,
        array $options,
        array $channelVariables = []
    ): Channel {
        /** @var Channel $channel */
        $channel = $this->postRequestReturningModel(
            Channel::class,
            "/channels/{$channelId}",
            [self::ENDPOINT => $endpoint] + $options,
            ['variables' => $channelVariables]
        );

        return $channel;
    }

    /**
     * Delete (i.e. hangup) a channel.
     *
     * @param string $channelId Channel's id.
     * @param string $reason Reason for hanging up the channel.
     * Allowed values: normal, busy, congestion, no_answer, timeout, rejected,
     *     unallocated, normal_unspecified, number_incomplete, codec_mismatch,
     *     interworking, failure, answered_elsewhere
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
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
     * @param string[] $options A collection of options when continuing in the dialplan.
     * context: string - The context to continue to.
     * extension: string - The extension to continue to.
     * priority: int - The priority to continue to.
     * label: string - The label to continue to - will supersede 'priority' if both are
     *     provided.
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
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
     * @param string[] $appArgs The application arguments to pass to the Stasis
     *     application provided by 'app'.
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function move(string $channelId, string $app, array $appArgs = []): void
    {
        $queryParameters = ['app' => $app];

        if ($appArgs !== []) {
            $queryParameters['appArgs'] = implode(',', $appArgs);
        }

        $this->postRequest("/channels/{$channelId}/move", $queryParameters);
    }

    /**
     * Redirect the channel to a different location.
     *
     * @param string $channelId Channel's id.
     * @param string $endpoint The endpoint to redirect the channel to.
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function redirect(string $channelId, string $endpoint): void
    {
        $this->postRequest(
            "/channels/{$channelId}/redirect",
            [self::ENDPOINT => $endpoint]
        );
    }

    /**
     * Answer a channel.
     *
     * @param string $channelId Channel's id.
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function answer(string $channelId): void
    {
        $this->postRequest("/channels/{$channelId}/answer");
    }

    /**
     * Indicate ringing to a channel.
     *
     * @param string $channelId Channel's id.
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function ring(string $channelId): void
    {
        $this->postRequest("/channels/{$channelId}/ring");
    }

    /**
     * Stop ringing indication on a channel if locally generated.
     *
     * @param string $channelId Channel's id.
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
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
     * @param array $options A collection of options when sending DTMF.
     * before: int - Amount of time to wait before DTMF digits (specified in milliseconds)
     *     start.
     * between: int - Amount of time in between DTMF digits (specified in milliseconds).
     *     Default: 100
     * duration: int - Length of each DTMF digit (specified in milliseconds). Default: 100
     * after: int - Amount of time to wait after DTMF digits (specified in milliseconds)
     *     end.
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
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
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
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
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function unMute(string $channelId, string $direction = 'both'): void
    {
        $this->deleteRequest("/channels/{$channelId}/mute", ['direction' => $direction]);
    }

    /**
     * Hold a channel.
     *
     * @param string $channelId Channel's id.
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function hold(string $channelId): void
    {
        $this->postRequest("/channels/{$channelId}/hold");
    }

    /**
     * Remove a channel from hold.
     *
     * @param string $channelId Channel's id.
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function unHold(string $channelId): void
    {
        $this->deleteRequest("/channels/{$channelId}/hold");
    }

    /**
     * Play music on hold to a channel. Using media operations such as /play on a channel
     * playing MOH in this manner will suspend MOH without resuming automatically.
     * If continuing music on hold is desired, the stasis application must reinitiate
     * music on hold.
     *
     * @param string $channelId Channel's id.
     * @param string $mohClass Music on hold class to use.
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
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
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function stopMoh(string $channelId): void
    {
        $this->deleteRequest("/channels/{$channelId}/moh");
    }

    /**
     * Play silence to a channel. Using media operations such as /play on a channel
     * playing silence in this manner will suspend silence without resuming
     * automatically.
     *
     * @param string $channelId Channel's id.
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
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
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function stopSilence(string $channelId): void
    {
        $this->deleteRequest("/channels/{$channelId}/silence");
    }

    /**
     * Start playback of media. The media URI may be any of a number of URI's.
     * Currently sound:, recording:, number:, digits:, characters:, and tone: URI's are
     * supported. This operation creates a playback resource that can be used to control
     * the playback of media
     * (pause, rewind, fast forward, etc.).
     *
     * @param string $channelId Channel's id.
     * @param string[] $media Media URIs to play.
     * @param array $options A collection of options when playing media to a channel.
     * lang: string - For sounds, selects language for sound.
     * offsetms: int - Number of milliseconds to skip before playing.
     *      Only applies to the first URI if multiple media URIs are specified.
     * skipms: int - Number of milliseconds to skip for forward/reverse operations.
     *     Default: 3000 playbackId: string - Playback ID.
     *
     * @return Playback
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function play(string $channelId, array $media, array $options = []): Playback
    {
        /** @var Playback $playback */
        $playback = $this->postRequestReturningModel(
            Playback::class,
            "/channels/{$channelId}/play",
            ['media' => implode(',', $media)] + $options
        );

        return $playback;
    }

    /**
     * Start playback of media and specify the playbackId.
     * The media URI may be any of a number of URI's.
     * Currently sound:, recording:, number:, digits:, characters:, and tone: URI's are
     * supported. This operation creates a playback resource that can be used to control
     * the playback of media
     * (pause, rewind, fast forward, etc.)
     *
     * @param string $channelId Channel's id.
     * @param string $playbackId Playback ID.
     * @param string[] $media Media URIs to play.
     * @param array $options A collection of options when playing media to a channel.
     * lang: string - For sounds, selects language for sound.
     * offsetms: int - Number of milliseconds to skip before playing.
     *      Only applies to the first URI if multiple media URIs are specified.
     * skipms: int - Number of milliseconds to skip for forward/reverse operations.
     *     Default: 3000
     *
     * @return Playback
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function playWithId(
        string $channelId,
        string $playbackId,
        array $media,
        array $options = []
    ): Playback {
        /** @var Playback $playback */
        $playback = $this->postRequestReturningModel(
            Playback::class,
            "/channels/{$channelId}/play/{$playbackId}",
            ['media' => implode(',', $media)] + $options
        );

        return $playback;
    }

    /**
     * Start a recording. Record audio from a channel.
     * Note that this will not capture audio sent to the channel.
     * The bridge itself has a record feature if that's what you want.
     *
     * @param string $channelId Channel's id.
     * @param string $name Recording's filename.
     * @param string $format Format to encode audio in.
     * @param array $options A collection of options when recording a channel-
     * maxDurationSeconds: int - Maximum duration of the recording, in seconds. 0 for no
     *     limit. Allowed range: Min: 0; Max: None
     * maxSilenceSeconds: int - Maximum duration of silence, in seconds. 0 for no limit.
     *     Allowed range: Min: 0; Max: None
     * ifExists: string - Action to take if a recording with the same name already exists.
     *     Default: fail Allowed values: fail, overwrite, append
     * beep: boolean - Play beep when recording begins.
     * terminateOn: string - DTMF input to terminate recording. Default: none.
     *     Allowed values: none, any, *, #
     *
     * @return LiveRecording
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function record(
        string $channelId,
        string $name,
        string $format,
        array $options = []
    ): LiveRecording {
        /** @var LiveRecording $liveRecording */
        $liveRecording = $this->postRequestReturningModel(
            LiveRecording::class,
            "/channels/{$channelId}/record",
            ['name' => $name, 'format' => $format] + $options
        );

        return $liveRecording;
    }

    /**
     * Get the value of a channel variable or function.
     *
     * @param string $channelId Channel's id.
     * @param string $variable The channel variable or function to get.
     *
     * @return Variable
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function getChannelVar(string $channelId, string $variable): Variable
    {
        /** @var Variable $variableModel */
        $variableModel = $this->getModelRequest(
            Variable::class,
            "/channels/{$channelId}/variable",
            ['variable' => $variable]
        );

        return $variableModel;
    }

    /**
     * Set the value of a channel variable or function.
     *
     * @param string $channelId Channel's id.
     * @param string $variable The channel variable or function to set
     * @param string $value The value to set the variable to
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function setChannelVar(
        string $channelId,
        string $variable,
        string $value
    ): void {
        $this->postRequest(
            "/channels/{$channelId}/variable",
            [],
            ['variable' => $variable, 'value' => $value]
        );
    }

    /**
     * Start snooping. Snoop (spy/whisper) on a specific channel.
     *
     * @param string $channelId Channel's id.
     * @param string $app Application the snooping channel is placed into.
     * @param string[] $options A collection of options when snooping a channel.
     * spy: string - Direction of audio to spy on. Default: none.
     *     Allowed values: none, both, out, in
     * whisper: string - Direction of audio to whisper into. Default: none.
     *     Allowed values: none, both, out, in
     * appArgs: string - The application arguments to pass to the Stasis application
     * snoopId: string - Unique ID to assign to snooping channel
     *
     * @return Channel
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function snoopChannel(
        string $channelId,
        string $app,
        array $options = []
    ): Channel {
        /** @var Channel $channel */
        $channel = $this->postRequestReturningModel(
            Channel::class,
            "/channels/{$channelId}/snoop",
            ['app' => $app] + $options
        );

        return $channel;
    }

    /**
     * Start snooping. Snoop (spy/whisper) on a specific channel.
     *
     * @param string $channelId Channel's id.
     * @param string $snoopId Unique ID to assign to snooping channel.
     * @param string $app Application the snooping channel is placed into.
     * @param string[] $options A collection of options when snooping on a channel.
     * spy: string - Direction of audio to spy on. Default: 'none'. Allowed values: none,
     *     both, out, in
     * whisper: string - Direction of audio to whisper into. Default: none.
     *     Allowed values: none, both, out, in
     * appArgs: string - The application arguments to pass to the Stasis application
     *
     * @return Channel
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function snoopChannelWithId(
        string $channelId,
        string $snoopId,
        string $app,
        array $options = []
    ): Channel {
        /** @var Channel $channel */
        $channel = $this->postRequestReturningModel(
            Channel::class,
            "/channels/{$channelId}/snoop/{$snoopId}",
            ['app' => $app] + $options,
        );

        return $channel;
    }

    /**
     * Dial a created channel.
     *
     * @param string $channelId Channel's id
     * @param string $caller Channel ID of caller
     * @param int $timeout Dial timeout. Allowed range: Min: 0; Max: None
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function dial(string $channelId, string $caller = '', int $timeout = 0): void
    {
        $queryParameters = [];

        if ($caller !== '') {
            $queryParameters['caller'] = $caller;
        }

        if ($timeout > 0) {
            $queryParameters['timeout'] = $timeout;
        }

        $this->postRequest("/channels/{$channelId}/dial", $queryParameters);
    }

    /**
     * RTP stats on a channel.
     *
     * @param string $channelId Channel's id
     *
     * @return RTPstat
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function rtpStatistics(string $channelId): RTPstat
    {
        /** @var RTPstat $rtpStat */
        $rtpStat = $this->getModelRequest(
            RTPstat::class,
            "/channels/{$channelId}/rtp_statistics"
        );

        return $rtpStat;
    }

    /**
     * Start an External Media session.
     *
     * Create a channel to an External Media source/sink.
     *
     * @see https://wiki.asterisk.org/wiki/display/AST/External+Media+and+ARI
     *
     * @param string app Stasis Application to place channel into
     * @param string $externalHost Hostname/ip:port of external host
     * @param string format Format to encode audio in,
     * Any standard format/codec supported by Asterisk is supported here.
     * For example: ulaw, g722, etc.
     * There is no negotiation. The format you specify is the format you'll get.
     * The channel driver will automatically transcode the bridge's native
     * media into this format.
     * @param array $options Optional parameters.
     * channelId: string - The unique id to assign the channel on creation.
     * encapsulation: string - Payload encapsulation protocol
     *      Default: rtp
     *      Allowed values: rtp
     * transport: string - Transport protocol
     *      Default: udp
     *      Allowed values: udp
     * connection_type: string - Connection type (client/server)
     *      Default: client
     *      Allowed values: client
     * direction: string - External media direction
     *      Default: both
     *      Allowed values: both
     * @param array $channelVariables The "variables" key in the body object
     * holds variable key/value pairs to set on the channel on creation.
     *
     * @return ExternalMedia
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function externalMedia(
        string $app,
        string $externalHost,
        string $format,
        array $options = [],
        array $channelVariables = []
    ): ExternalMedia
    {
        /**
         * @var ExternalMedia $externalMedia
         */
        $externalMedia = $this->postRequestReturningModel(
            ExternalMedia::class,
            '/channels/externalMedia',
            [
                'app' => $app,
                'external_host' => $externalHost,
                'format' => $format
            ] + $options,
            ['variables' => $channelVariables]
        );

        return $externalMedia;
    }
}
