<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\RestClient;

use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use NgVoice\AriClient\Models\{Endpoint, Model};

/**
 * An implementation of the Endpoints REST client for the
 * Asterisk REST Interface
 *
 * @see https://wiki.asterisk.org/wiki/display/AST/Asterisk+16+Endpoints+REST+API
 *
 * @package NgVoice\AriClient\RestClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Endpoints extends AsteriskRestInterfaceClient
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
        return $this->getArrayOfModelInstancesRequest(Endpoint::class, '/endpoints');
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
        $this->putRequest(
            '/endpoints/sendMessage',
            ['to' => $to, 'from' => $from, 'body' => $body]
        );
    }

    /**
     * List available endoints for a given endpoint technology.
     *
     * @param string $tech Technology of the endpoints (sip,iax2,...).
     *
     * @return Endpoint[]
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function listByTech(string $tech): array
    {
        return $this->getArrayOfModelInstancesRequest(
            Endpoint::class,
            "/endpoints/{$tech}"
        );
    }

    /**
     * Details for an endpoint.
     *
     * @param string $tech Technology of the endpoint.
     * @param string $resource ID of the endpoint.
     *
     * @return Endpoint|Model
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function get(string $tech, string $resource): Endpoint
    {
        return $this->getModelRequest(Endpoint::class, "/endpoints/{$tech}/{$resource}");
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
        $this->putRequest(
            "/endpoints/{$tech}/{$resource}/sendMessage",
            ['from' => $from, 'body' => $body]
        );
    }
}
