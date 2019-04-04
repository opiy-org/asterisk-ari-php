<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\RestClient;


use GuzzleHttp\Exception\GuzzleException;
use NgVoice\AriClient\Model\Endpoint;

/**
 * Class Endpoints
 * @package NgVoice\AriClient\RestClient
 */
final class Endpoints extends AriRestClient
{
    /**
     * List all endpoints.
     *
     * @return Endpoint[]
     * @throws GuzzleException
     */
    public function list(): array
    {
        return $this->getRequest('/endpoints', [], parent::ARRAY, Endpoint::class);
    }

    /**
     * Send a message to some technology URI or endpoint.
     *
     * @param string $to The endpoint resource or technology specific URI to send the message to.
     * Valid resources are sip, pjsip, and xmpp.
     * @param string $from The endpoint resource or technology specific identity to send this message from.
     * Valid resources are sip, pjsip, and xmpp.
     * @param string $body The body of the message.
     * @throws GuzzleException
     */
    public function sendMessage(string $to, string $from, string $body = ''): void
    {
        $this->putRequest('/endpoints/sendMessage', ['to' => $to, 'from' => $from, 'body' => $body]);
    }

    /**
     * List available endoints for a given endpoint technology.
     *
     * @param string $tech Technology of the endpoints (sip,iax2,...).
     * @return Endpoint[]
     * @throws GuzzleException
     */
    public function listByTech(string $tech): array
    {
        return $this->getRequest("/endpoints/{$tech}", [], parent::ARRAY, Endpoint::class);
    }

    /**
     * Details for an endpoint.
     *
     * @param string $tech Technology of the endpoint.
     * @param string $resource ID of the endpoint.
     * @return Endpoint|object
     * @throws GuzzleException
     */
    public function get(string $tech, string $resource): Endpoint
    {
        return $this->getRequest("/endpoints/{$tech}/{$resource}", [], parent::MODEL, Endpoint::class);
    }

    /**
     * Send a message to some endpoint in a technology.
     *
     * @param string $tech Technology of the endpoint.
     * @param string $resource ID of the endpoint.
     * @param string $from The endpoint resource or technology specific identity to send this message from.
     * Valid resources are sip, pjsip, and xmpp.
     * @param string $body The body of the message.
     * @throws GuzzleException
     */
    public function sendMessageToEndpoint(string $tech, string $resource, string $from, string $body = ''): void
    {
        $this->putRequest("/endpoints/{$tech}/{$resource}/sendMessage", ['from' => $from, 'body' => $body]);
    }
}