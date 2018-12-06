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

/**
 * A specific communication connection between Asterisk and an Endpoint.
 *
 * @package AriStasisApp\ariclients
 */
class Channels extends AriRestClient
{
    /**
     *
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface TODO: List[Channel]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function list()
    {
        return $this->getRequest('/channels');
    }

    /**
     * @param string $endpoint e.g. SIP/alice
     * @param array $options
     * @param array $channelVariables
     * @return Channel|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    function originate(string $endpoint, array $options = [], array $channelVariables = []): Channel
    {
        $body = array_merge(['endpoint' => $endpoint, 'variables' => $channelVariables], $options);
        $response = $this->postRequest('/channels', [], $body);
        return $this->jsonMapper->map(json_decode($response->getBody()), new Channel());
    }

    /**
     * @param string $endpoint
     * @param string $stasisApp
     * @param array $options
     * @return Channel|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    function create(string $endpoint, string $stasisApp, array $options = []): Channel
    {
        $response = $this->postRequest('/channels/create', array_merge([$endpoint, $stasisApp], $options));
        return $this->jsonMapper->map(json_decode($response->getBody()), new Channel());

    }

    /**
     * @param string $id
     * @return Channel|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    function get(string $id): Channel
    {
        $response = $this->getRequest("/channels/{$id}");
        return $this->jsonMapper->map(json_decode($response->getBody()), new Channel());
    }

    /**
     * @param string $channelId
     * @param string $endpoint
     * @param array $options
     * @param array $channelVariables
     * @return Channel|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    function originateWithId(string $channelId, string $endpoint, array $options = [], $channelVariables = []): Channel
    {
        $body = array_merge(['endpoint' => $endpoint, 'variables' => $channelVariables], $options);
        $response = $this->postRequest("/channels/{$channelId}", [], $body);
        return $this->jsonMapper->map(json_decode($response->getBody()), new Channel());
    }

    /**
     * @param string $channelId
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function hangup(string $channelId): void
    {
        $this->deleteRequest("/channels/{$channelId}");
    }

    /**
     * @param string $channelId
     * @param string $context
     * @param string $extension
     * @param string $priority
     * @param string $label
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function continueInDialPlan(
        string $channelId,
        string $context,
        string $extension,
        string $priority,
        string $label
    ): void {
        $this->postRequest("/channels/{$channelId}/continue", [$context, $extension, $priority, $label]);
    }

    /**
     * @param string $channelId
     * @param string $endpoint
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function redirect(string $channelId, string $endpoint): void
    {
        $this->postRequest("/channels/{$channelId}/redirect", [$endpoint]);
    }

    /**
     * @param string $channelId
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function answer(string $channelId): void
    {
        $this->postRequest("/channels/{$channelId}/answer");
    }

    /**
     * @param string $channelId
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function ring(string $channelId): void
    {
        $this->postRequest("/channels/{$channelId}/ring");
    }

    /**
     * @param string $channelId
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function ringStop(string $channelId): void
    {
        $this->deleteRequest("/channels/{$channelId}/ring");
    }

    /**
     * @param string $channelId
     * @param string $dtmf
     * @param array $options
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function sendDtmf(string $channelId, string $dtmf, array $options = []): void
    {
        $this->postRequest("/channels/{$channelId}/dtmf",
            array_merge(['dtmf' => $dtmf, 'before' => 0, 'between' => 100, 'duration' => 100, 'after' => 0], $options));
    }

    /**
     * @param string $channelId
     * @param string $direction
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function mute(string $channelId, string $direction): void
    {
        $this->postRequest("/channels/{$channelId}/mute", ['direction' => $direction]);
    }

    /**
     * @param string $channelId
     * @param string $direction
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function unMute(string $channelId, string $direction): void
    {
        $this->deleteRequest("/channels/{$channelId}/mute", [$direction]);
    }

    /**
     * @param string $channelId
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function hold(string $channelId): void
    {
        $this->postRequest("/channels/{$channelId}/hold");
    }

    /**
     * @param string $channelId
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function unHold(string $channelId): void
    {
        $this->deleteRequest("/channels/{$channelId}/hold");
    }

    /**
     * @param string $channelId
     * @param string $mohClass
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function startMoh(string $channelId, string $mohClass): void
    {
        $this->postRequest("/channels/{$channelId}/moh", [$mohClass]);
    }

    /**
     * @param string $channelId
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function stopMoh(string $channelId): void
    {
        $this->deleteRequest("/channels/{$channelId}/moh");
    }

    /**
     * @param string $channelId
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function startSilence(string $channelId): void
    {
        $this->postRequest("/channels/{$channelId}/silence");
    }

    /**
     * @param string $channelId
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function stopSilence(string $channelId): void
    {
        $this->deleteRequest("/channels/{$channelId}/silence");
    }

    /**
     * @param string $channelId
     * @param array $media
     * @param array $options
     * @return Playback|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    function play(string $channelId, array $media, array $options = []): Playback
    {
        $media = glueArrayOfStrings($media);
        $response = $this->postRequest("/channels/{$channelId}/play",
            array_merge(['media' => $media], $options));
        return $this->jsonMapper->map(json_decode($response->getBody()), new Playback());
    }

    /**
     * @param string $channelId
     * @param string $playbackId
     * @param array $media
     * @param array $options
     * @return Playback|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    function playWithId(string $channelId, string $playbackId, array $media, array $options = []): Playback
    {
        $media = glueArrayOfStrings($media);
        $response = $this->postRequest("/channels/{$channelId}/play/{$playbackId}",
            array_merge(['media' => $media], $options));
        return $this->jsonMapper->map(json_decode($response->getBody()), new Playback());
    }

    /**
     * @param string $channelId
     * @param string $name
     * @param string $format
     * @param array $options
     * @return LiveRecording|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    function record(string $channelId, string $name, string $format, array $options = []): LiveRecording
    {
        $response = $this->postRequest("/channels/{$channelId}/record",
            array_merge(['name' => $name, 'format' => $format], $options));
        return $this->jsonMapper->map(json_decode($response->getBody()), new LiveRecording());
    }

    /**
     *
     * @param string $channelId
     * @param string $key
     * @return Variable|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    function getVariable(string $channelId, string $key): Variable
    {
        $response = $this->getRequest("/channels/{$channelId}/variable", ['variable' => $key]);
        return $this->jsonMapper->map(json_decode($response->getBody()), new Variable());
    }

    /**
     *
     * @param string $channelId
     * @param string $key
     * @param int|string $value
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function setVariable(string $channelId, string $key, $value): void
    {
        $this->postRequest("/channels/{$channelId}/variable", [], ['variable' => $key, 'value' => $value]);
    }

    /**
     * @param string $channelId
     * @param string $app
     * @param array $options
     * @return Channel|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    function snoopChannel(string $channelId, string $app, array $options = []): Channel
    {
        $response = $this->postRequest("/channels/{$channelId}/snoop",
            array_merge(['app' => $app], $options));
        return $this->jsonMapper->map(json_decode($response->getBody()), new Channel());
    }

    /**
     * @param string $channelId
     * @param string $snoopId
     * @param string $app
     * @param array $options
     * @return Channel|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    function snoopChannelWithId(string $channelId, string $snoopId, string $app, array $options = []): Channel
    {
        $response = $this->postRequest("/channels/{$channelId}/snoop/{$snoopId}",
            array_merge(['app' => $app], $options));
        return $this->jsonMapper->map(json_decode($response->getBody()), new Channel());
    }

    /**
     * @param string $channelId
     * @param string $caller
     * @param int $timeout
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function dial(string $channelId, string $caller, int $timeout): void
    {
        $this->postRequest("/channels/{$channelId}/dial", ['caller' => $caller, 'timeout' => $timeout]);
    }
}