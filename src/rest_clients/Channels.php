<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\rest_clients;

use AriStasisApp\models\Channel;
use AriStasisApp\models\LiveRecording;
use AriStasisApp\models\Playback;
use AriStasisApp\models\Variable;
use function AriStasisApp\glueArrayOfStrings;
use function AriStasisApp\mapJsonArrayToAriObjects;
use function AriStasisApp\mapJsonToAriObject;

/**
 * A specific communication connection between Asterisk and an Endpoint.
 *
 * @package AriStasisApp\ariclients
 */
class Channels extends AriRestClient
{
    /**
     * @return Channel[]|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function list()
    {
        return mapJsonArrayToAriObjects(
            $this->getRequest('/channels'),
            'AriStasisApp\models\Channel',
            $this->jsonMapper,
            $this->logger
        );
    }

    /**
     * @param string $endpoint e.g. SIP/alice
     * @param array $options
     * @param array $channelVariables
     * @return Channel|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function originate(string $endpoint, array $options = [], array $channelVariables = []): Channel
    {
        $body = array_merge(['endpoint' => $endpoint, 'variables' => $channelVariables], $options);
        return mapJsonToAriObject(
            $this->postRequest('/channels', [], $body),
            'AriStasisApp\models\Channel',
            $this->jsonMapper,
            $this->logger
        );
    }

    /**
     * @param string $endpoint
     * @param string $stasisApp
     * @param array $options
     * @return Channel|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function create(string $endpoint, string $stasisApp, array $options = []): Channel
    {
        return mapJsonToAriObject(
            $this->postRequest('/channels/create', array_merge([$endpoint, $stasisApp], $options)),
            'AriStasisApp\models\Channel',
            $this->jsonMapper,
            $this->logger
        );
    }

    /**
     * @param string $id
     * @return Channel|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function get(string $id): Channel
    {
        return mapJsonToAriObject(
            $this->getRequest("/channels/{$id}"),
            'AriStasisApp\models\Channel',
            $this->jsonMapper,
            $this->logger
        );
    }

    /**
     * @param string $channelId
     * @param string $endpoint
     * @param array $options
     * @param array $channelVariables
     * @return Channel|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function originateWithId(string $channelId, string $endpoint, array $options = [], $channelVariables = []): Channel
    {
        $body = array_merge(['endpoint' => $endpoint, 'variables' => $channelVariables], $options);
        return mapJsonToAriObject(
            $this->postRequest("/channels/{$channelId}", [], $body),
            'AriStasisApp\models\Channel',
            $this->jsonMapper,
            $this->logger
        );
    }

    /**
     *
     *
     * @param string $channelId
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function hangup(string $channelId): void
    {
        $this->deleteRequest("/channels/{$channelId}");
    }

    /**
     * Exit application; continue execution in the dialplan.
     *
     * @param string $channelId Channel's id.
     * @param string|null $context The context to continue to.
     * @param string|null $extension The extension to continue to.
     * @param string|null $priority The priority to continue to.
     * @param string|null $label The label to continue to - will supersede 'priority' if both are provided.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function continueInDialPlan(
        string $channelId,
        ?string $context,
        ?string $extension,
        ?string $priority,
        ?string $label
    ): void {
        $queryParameters = [];
        if (!is_null($context)) {
            $queryParameters['context'] = $context;
        }
        if (!is_null($extension)) {
            $queryParameters['extension'] = $extension;
        }
        if (!is_null($priority)) {
            $queryParameters['priority'] = $priority;
        }
        if (!is_null($label)) {
            $queryParameters['label'] = $label;
        }
        $this->postRequest("/channels/{$channelId}/continue", $queryParameters);
    }

    /**
     * Redirect the channel to a different location.
     *
     * @param string $channelId Channel's id.
     * @param string $endpoint The endpoint to redirect the channel to.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function redirect(string $channelId, string $endpoint): void
    {
        $this->postRequest("/channels/{$channelId}/redirect", ['endpoint' => $endpoint]);
    }

    /**
     * Answer a channel.
     *
     * @param string $channelId Channel's id.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function answer(string $channelId): void
    {
        $this->postRequest("/channels/{$channelId}/answer");
    }

    /**
     * Indicate ringing to a channel.
     *
     * @param string $channelId Channel's id.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function ring(string $channelId): void
    {
        $this->postRequest("/channels/{$channelId}/ring");
    }

    /**
     * Stop ringing indication on a channel if locally generated.
     *
     * @param string $channelId Channel's id.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function ringStop(string $channelId): void
    {
        $this->deleteRequest("/channels/{$channelId}/ring");
    }

    /**
     * Send provided DTMF to a given channel.
     *
     * @param string $channelId Channel's id.
     * @param string $dtmf DTMF To send.
     * @param int $before Amount of time to wait before DTMF digits (specified in milliseconds) start.
     * @param int $between Amount of time in between DTMF digits (specified in milliseconds).
     * @param int $duration Length of each DTMF digit (specified in milliseconds).
     * @param int $after Amount of time to wait after DTMF digits (specified in milliseconds) end.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function sendDtmf(
        string $channelId,
        string $dtmf,
        int $before = 0,
        int $between = 100,
        int $duration = 100,
        int $after = 0
    ): void {
        $this->postRequest(
            "/channels/{$channelId}/dtmf",
            ['dtmf' => $dtmf, 'before' => $before, 'between' => $between, 'duration' => $duration, 'after' => $after]
        );
    }

    /**
     * Mute a channel.
     *
     * @param string $channelId Channel's id.
     * @param string $direction Direction in which to mute audio (both, in, out).
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function mute(string $channelId, string $direction = 'both'): void
    {
        $this->postRequest("/channels/{$channelId}/mute", ['direction' => $direction]);
    }

    /**
     * Unmute a channel.
     *
     * @param string $channelId Channel's id.
     * @param string $direction Direction in which to unmute audio (both, in, out).
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function unMute(string $channelId, string $direction = 'both'): void
    {
        $this->deleteRequest("/channels/{$channelId}/mute", ['direction' => $direction]);
    }

    /**
     * Hold a channel.
     *
     * @param string $channelId Channel's id.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function hold(string $channelId): void
    {
        $this->postRequest("/channels/{$channelId}/hold");
    }

    /**
     * Remove a channel from hold.
     *
     * @param string $channelId Channel's id.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function unHold(string $channelId): void
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function startMoh(string $channelId, string $mohClass): void
    {
        $this->postRequest("/channels/{$channelId}/moh", [$mohClass]);
    }

    /**
     * Stop playing music on hold to a channel.
     *
     * @param string $channelId Channel's id.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function stopMoh(string $channelId): void
    {
        $this->deleteRequest("/channels/{$channelId}/moh");
    }

    /**
     * Play silence to a channel. Using media operations such as /play on a channel playing
     * silence in this manner will suspend silence without resuming automatically.
     *
     * @param string $channelId Channel's id.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function startSilence(string $channelId): void
    {
        $this->postRequest("/channels/{$channelId}/silence");
    }

    /**
     * Play silence to a channel. Using media operations such as /play on a channel
     * playing silence in this manner will suspend silence without resuming automatically.
     *
     * @param string $channelId Channel's id
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function stopSilence(string $channelId): void
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
     * @param string|null $lang For sounds, selects language for sound.
     * @param int $offsetms Number of milliseconds to skip before playing.
     * Only applies to the first URI if multiple media URIs are specified.
     * @param int $skipms Number of milliseconds to skip for forward/reverse operations.
     * @param string|null $playbackId Playback ID.
     * @return Playback|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function play(
        string $channelId,
        array $media,
        ?string $lang,
        ?string $playbackId,
        int $offsetms = 0,
        int $skipms = 3000
    ): Playback {
        $media = glueArrayOfStrings($media);
        $queryParameters = ['media' => $media, 'offsetms' => $offsetms, 'skipms' => $skipms];
        if (!is_null($lang)) {
            $queryParameters['lang'] = $lang;
        }
        if (!is_null($playbackId)) {
            $queryParameters['playbackId'] = $playbackId;
        }
        return mapJsonToAriObject(
            $this->postRequest("/channels/{$channelId}/play", $queryParameters),
            'AriStasisApp\models\Playback',
            $this->jsonMapper,
            $this->logger
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
     * @param string $lang For sounds, selects language for sound.
     * @param int $offsetms Number of milliseconds to skip before playing.
     * Only applies to the first URI if multiple media URIs are specified.
     * @param int $skipms Number of milliseconds to skip for forward/reverse operations.
     * @return Playback|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function playWithId(
        string $channelId,
        string $playbackId,
        array $media,
        ?string $lang,
        int $offsetms = 0,
        int $skipms = 3000
    ): Playback {
        $media = glueArrayOfStrings($media);
        $queryParameters = ['media' => $media, 'offsetms' => $offsetms, 'skipms' => $skipms];
        if (!is_null($lang)) {
            $queryParameters['lang'] = $lang;
        }
        return mapJsonToAriObject(
            $this->postRequest("/channels/{$channelId}/play/{$playbackId}", $queryParameters),
            'AriStasisApp\models\Playback',
            $this->jsonMapper,
            $this->logger
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
     * @param int $maxDurationSeconds Maximum duration of the recording, in seconds. 0 for no limit.
     * Allowed range: Min: 0; Max: None
     * @param int $maxSilenceSeconds Maximum duration of silence, in seconds. 0 for no limit.
     * Allowed range: Min: 0; Max: None
     * @param string $ifExists Action to take if a recording with the same name already exists.
     * Allowed values: fail, overwrite, append
     * @param bool $beep Play beep when recording begins
     * @param string $terminateOn DTMF input to terminate recording (Allowed values: none, any, *, #).
     * @return LiveRecording|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function record(
        string $channelId,
        string $name,
        string $format,
        int $maxDurationSeconds = 0,
        int $maxSilenceSeconds = 0,
        string $ifExists = 'fail',
        bool $beep = true,
        string $terminateOn = 'none'
    ): LiveRecording {
        $queryParameters =
            [
                'name' => $name,
                'format' => $format,
                'maxDurationSeconds' => $maxDurationSeconds,
                'maxSilenceSeconds' => $maxSilenceSeconds,
                'ifExists' => $ifExists,
                'beep' => $beep,
                'terminateOn' => $terminateOn
            ];
        return mapJsonToAriObject(
            $this->postRequest("/channels/{$channelId}/record", $queryParameters),
            'AriStasisApp\models\LiveRecording',
            $this->jsonMapper,
            $this->logger
        );
    }

    /**
     * Get the value of a channel variable or function.
     *
     * @param string $channelId Channel's id.
     * @param string $variable The channel variable or function to get.
     * @return Variable|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function getVariable(string $channelId, string $variable): Variable
    {
        return mapJsonToAriObject(
            $this->getRequest("/channels/{$channelId}/variable", ['variable' => $variable]),
            'AriStasisApp\models\Variable',
            $this->jsonMapper,
            $this->logger
        );
    }

    /**
     * Set the value of a channel variable or function.
     *
     * @param string $channelId Channel's id.
     * @param string $variable The channel variable or function to set
     * @param int|string $value The value to set the variable to
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function setVariable(string $channelId, string $variable, $value): void
    {
        $this->postRequest("/channels/{$channelId}/variable", [], ['variable' => $variable, 'value' => $value]);
    }

    /**
     * Start snooping. Snoop (spy/whisper) on a specific channel.
     *
     * @param string $channelId Channel's id.
     * @param string $app Application the snooping channel is placed into.
     * @param array|null $appArgs The application arguments to pass to the Stasis application.
     * @param string|null $snoopId Unique ID to assign to snooping channel.
     * @param string|null $spy Direction of audio to spy on (none, both, out, in).
     * @param string|null $whisper Direction of audio to whisper into (none, both, out, in).
     * @return Channel|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function snoopChannel(
        string $channelId,
        string $app,
        ?array $appArgs,
        ?string $snoopId,
        ?string $spy,
        ?string $whisper
    ): Channel {
        $queryParameters = ['app' => $app];
        if (!is_null($appArgs)) {
            $queryParameters['appArgs'] = glueArrayOfStrings($appArgs);
        }
        if (!is_null($snoopId)) {
            $queryParameters['snoopId'] = $snoopId;
        }
        if (!is_null($spy)) {
            $queryParameters['spy'] = $spy;
        }
        if (!is_null($whisper)) {
            $queryParameters['whisper'] = $whisper;
        }
        return mapJsonToAriObject(
            $this->postRequest("/channels/{$channelId}/snoop", $queryParameters),
            'AriStasisApp\models\Channel',
            $this->jsonMapper,
            $this->logger
        );
    }

    /**
     * Start snooping. Snoop (spy/whisper) on a specific channel.
     *
     * @param string $channelId Channel's id.
     * @param string $snoopId Unique ID to assign to snooping channel.
     * @param string $app Application the snooping channel is placed into.
     * @param array|null $appArgs The application arguments to pass to the Stasis application.
     * @param string|null $spy Direction of audio to spy on (none, both, out, in).
     * @param string|null $whisper Direction of audio to whisper into (none, both, out, in).
     * @return Channel|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function snoopChannelWithId(
        string $channelId,
        string $snoopId,
        string $app,
        ?array $appArgs,
        ?string $spy,
        ?string $whisper
    ): Channel {
        $queryParameters = ['app' => $app];
        if (!is_null($appArgs)) {
            $queryParameters['appArgs'] = glueArrayOfStrings($appArgs);
        }
        if (!is_null($spy)) {
            $queryParameters['spy'] = $spy;
        }
        if (!is_null($whisper)) {
            $queryParameters['whisper'] = $whisper;
        }
        return mapJsonToAriObject(
            $this->postRequest("/channels/{$channelId}/snoop/{$snoopId}", $queryParameters),
            'AriStasisApp\models\Channel',
            $this->jsonMapper,
            $this->logger
        );
    }

    /**
     * Dial a created channel.
     *
     * @param string $channelId Channel's id
     * @param string $caller Channel ID of caller
     * @param int $timeout Dial timeout. Allowed range: Min: 0; Max: None
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function dial(string $channelId, string $caller, int $timeout): void
    {
        $this->postRequest("/channels/{$channelId}/dial", ['caller' => $caller, 'timeout' => $timeout]);
    }
}