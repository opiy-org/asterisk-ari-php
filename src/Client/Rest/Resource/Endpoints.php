<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Client\Rest\Resource;

use NgVoice\AriClient\Client\Rest\AbstractRestClient;
use NgVoice\AriClient\Collection\HttpMethods;
use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use NgVoice\AriClient\Model\Endpoint;

/**
 * An implementation of the Endpoints REST client for the
 * Asterisk REST Interface
 *
 * @see https://wiki.asterisk.org/wiki/display/AST/Asterisk+16+Endpoints+REST+API
 *
 * @package NgVoice\AriClient\RestClient\Resource
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Endpoints extends AbstractRestClient
{
    /**
     * List all endpoints.
     *
     * @return Endpoint[]
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function list(): array
    {
        $response = $this->sendRequest(HttpMethods::GET, '/endpoints');

        /** @var Endpoint[] $endpoints */
        $endpoints = [];
        $this->responseToArrayOfAriModelInstances(
            $response,
            new Endpoint(),
            $endpoints
        );

        return $endpoints;
    }

    /**
     * Send a message to some technology URI or endpoint.
     *
     * @param string $to The endpoint resource or technology specific URI to send the
     *     message to. Valid resources are sip, pjsip, and xmpp.
     * @param string $from The endpoint resource or technology specific identity to send
     *     this message from. Valid resources are sip, pjsip, and xmpp.
     * @param string $body The body of the message.
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function sendMessage(string $to, string $from, string $body = ''): void
    {
        $this->sendRequest(
            HttpMethods::PUT,
            '/endpoints/sendMessage',
            [],
            ['to' => $to, 'from' => $from, 'body' => $body]
        );
    }

    /**
     * List available endpoints for a given endpoint technology.
     *
     * @param string $tech Technology of the endpoints (sip, iax2, ...).
     *
     * @return Endpoint[]
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function listByTech(string $tech): array
    {
        $response = $this->sendRequest(HttpMethods::GET, "/endpoints/{$tech}");

        /** @var Endpoint[] $endpoints */
        $endpoints = [];
        $this->responseToArrayOfAriModelInstances(
            $response,
            new Endpoint(),
            $endpoints
        );

        return $endpoints;
    }

    /**
     * Details for an endpoint.
     *
     * @param string $tech Technology of the endpoint.
     * @param string $resource ID of the endpoint.
     *
     * @return Endpoint
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function get(string $tech, string $resource): Endpoint
    {
        $response = $this->sendRequest(
            HttpMethods::GET,
            "/endpoints/{$tech}/{$resource}"
        );

        $endpoint = new Endpoint();
        $this->responseToAriModelInstance($response, $endpoint);

        return $endpoint;
    }

    /**
     * Send a message to some endpoint in a technology.
     *
     * @param string $tech Technology of the endpoint.
     * @param string $resource ID of the endpoint.
     * @param string $from The endpoint resource or technology specific identity to send
     *     this message from. Valid resources are sip, pjsip, and xmpp.
     * @param string $body The body of the message.
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function sendMessageToEndpoint(
        string $tech,
        string $resource,
        string $from,
        string $body = ''
    ): void {
        $this->sendRequest(
            HttpMethods::PUT,
            "/endpoints/{$tech}/{$resource}/sendMessage",
            [],
            ['from' => $from, 'body' => $body]
        );
    }
}
