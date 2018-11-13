<?php
/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 */
namespace AriStasisApp\http_client;

/**
 * Class ChannelsRestClient
 * @package AriStasisApp\ariclients
 */
class ChannelsRestClient extends AriRestClient
{
    /**
     *
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function list()
    {
        return $this->getRequest('/channels');
    }

    /**
     *
     * @param string $endpoint e.g. SIP/alice
     * @param array $options
     * @param array $channelVariables
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function originate(string $endpoint,array $options = [], array $channelVariables = [])
    {
        $body = array_merge(['endpoint' => $endpoint, 'variables' => $channelVariables], $options);
        return $this->postRequest('/channels', [], $body);
    }

    /**
     * @param string $endpoint
     * @param string $stasisApp
     * @param array $options
     */
    function create(string $endpoint, string $stasisApp, array $options = [])
    {
        $this->postRequest('/channels/create', array_merge([$endpoint, $stasisApp], $options));
    }

    /**
     *
     * @param string $id
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function get(string $id)
    {
        return $this->getRequest("/channels/{$id}");
    }

    /**
     * @param string $channelId
     * @param string $endpoint
     * @param array $options
     * @param array $channelVariables
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function originateWithId(string $channelId, string $endpoint, array $options = [], $channelVariables = [])
    {
        $body = array_merge(['endpoint' => $endpoint, 'variables' => $channelVariables], $options);
        return $this->postRequest("/channels/{$channelId}", [], $body);
    }

    /**
     * @param string $channelId
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function hangup(string $channelId)
    {
        return $this->deleteRequest("/channels/{$channelId}");
    }

    /**
     * @param string $channelId
     * @param string $context
     * @param string $extension
     * @param string $priority
     * @param string $label
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function continueInDialPlan(string $channelId, string $context, string $extension, string $priority, string $label)
    {
        return $this->postRequest("/channels/{$channelId}/continue", [$context, $extension, $priority, $label]);
    }

    /**
     * @param string $channelId
     * @param string $endpoint
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function redirect(string $channelId, string $endpoint)
    {
        return $this->postRequest("/channels/{$channelId}/redirect", [$endpoint]);
    }

    /**
     * @param string $channelId
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function answer(string $channelId)
    {
        return $this->postRequest("/channels/{$channelId}/answer");
    }

    /**
     * @param string $channelId
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function ring(string $channelId)
    {
        return $this->postRequest("/channels/{$channelId}/ring");
    }

    /**
     * @param string $channelId
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function ringStop(string $channelId)
    {
        return $this->deleteRequest("/channels/{$channelId}/ring");
    }

    /**
     * @param string $channelId
     * @param string $dtmf
     * @param string $before
     * @param string $between
     * @param string $duration
     * @param string $after
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function sendDtmf(string $channelId, string $dtmf, string $before, string $between, string $duration, string $after)
    {
        return $this->postRequest("/channels/{$channelId}/dtmf", [$dtmf, $before, $between, $duration, $after]);
    }

    /**
     * @param string $channelId
     * @param string $direction
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function mute(string $channelId, string $direction)
    {
        return $this->postRequest("/channels/{$channelId}/mute", [$direction]);
    }

    /**
     * @param string $channelId
     * @param string $direction
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function unMute(string $channelId, string $direction)
    {
        return $this->deleteRequest("/channels/{$channelId}/mute", [$direction]);
    }

    /**
     * @param string $channelId
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function hold(string $channelId)
    {
        return $this->postRequest("/channels/{$channelId}/hold");
    }

    /**
     * @param string $channelId
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function unHold(string $channelId)
    {
        return $this->deleteRequest("/channels/{$channelId}/hold");
    }

    /**
     * @param string $channelId
     * @param string $mohClass
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function startMoh(string $channelId, string $mohClass)
    {
        return $this->postRequest("/channels/{$channelId}/moh", [$mohClass]);
    }

    /**
     * @param string $channelId
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function stopMoh(string $channelId)
    {
        return $this->deleteRequest("/channels/{$channelId}/moh");
    }

    /**
     * @param string $channelId
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function startSilence(string $channelId)
    {
        return $this->postRequest("/channels/{$channelId}/silence");
    }

    /**
     * @param string $channelId
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function stopSilence(string $channelId)
    {
        return $this->deleteRequest("/channels/{$channelId}/silence");
    }

    /**
     * @param string $channelId
     * @param array $media
     * @param array $options
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function play(string $channelId, array $media, array $options = [])
    {
        // TODO: Split media into comma separated string
        return $this->postRequest("/channels/{$channelId}/play",
            array_merge(['media' => $media], $options));
    }

    /**
     * @param string $channelId
     * @param string $playbackId
     * @param array $media
     * @param array $options
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function playWithId(string $channelId, string $playbackId, array $media, array $options = [])
    {
        // TODO: Split media into comma separated string
        return $this->postRequest("/channels/{$channelId}/play/{$playbackId}",
            array_merge(['media' => $media], $options));
    }

    /**
     * @param string $channelId
     * @param string $name
     * @param string $format
     * @param array $options
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function record(string $channelId, string $name, string $format, array $options = [])
    {
        return $this->postRequest("/channels/{$channelId}/record",
            array_merge(['name' => $name, 'format' => $format], $options));
    }

    /**
     *
     * @param string $channelId
     * @param string $key
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function getVariable(string $channelId, string $key)
    {
        return $this->getRequest("/channels/{$channelId}/variable", ['variable' => $key]);
    }

    /**
     *
     * @param string $channelId
     * @param string $key
     * @param int|string $value
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function setVariable(string $channelId, string $key, $value)
    {
        return $this->postRequest("/channels/{$channelId}/variable",
            [], ['variable' => $key, 'value' => $value]);
    }

    /**
     * @param string $channelId
     * @param string $app
     * @param array $options
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function snoopChannel(string $channelId, string $app, array $options = [])
    {
        return $this->postRequest("/channels/{$channelId}/snoop",
            array_merge(['app' => $app], $options));
    }

    /**
     * @param string $channelId
     * @param string $snoopId
     * @param string $app
     * @param array $options
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function snoopChannelWithId(string $channelId, string $snoopId, string $app, array $options = [])
    {
        return $this->postRequest("/channels/{$channelId}/snoop/{$snoopId}",
            array_merge(['app' => $app], $options));
    }

    /**
     * @param string $channelId
     * @param string $caller
     * @param int $timeout
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function dial(string $channelId, string $caller, int $timeout)
    {
        return $this->postRequest("/channels/{$channelId}/dial", ['caller' => $caller, 'timeout' => $timeout]);
    }
}