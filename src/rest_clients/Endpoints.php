<?php

/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 *
 * @OA\Info(
 *     title="Asterisk ARI Library",
 *     version="0.1",
 *     @OA\Contact(
 *         email="support@ng-voice.com"
 *     )
 * )
 *
 */

namespace AriStasisApp\rest_clients;


use AriStasisApp\models\Endpoint;

/**
 * Class Endpoints
 *
 * @package AriStasisApp\ariclients TODO: Change pakckage name in every Client to the correct one.
 */
class Endpoints extends AriRestClient
{
    /**
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface TODO: List[Endpoint]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function list(): array
    {
        return $this->getRequest('/endpoints');
    }

    /**
     * @param string $to
     * @param string $from
     * @param string $body TODO: This is weird in the documentation. Report issue,
     *   because it is unclear if the body in the request has to be set or if
     *   the body is delivered via a string in the query parameter.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function sendMessage(string $to, string $from, string $body): void
    {
        $this->putRequest("/endpoints/sendMessage", ['to' => $to, 'from' => $from, 'body' => $body]);
    }

    /**
     * @param string $tech
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function listByTech(string $tech)
    {
        return $this->getRequest("/endpoints/{$tech}");
    }

    /**
     * @param string $tech
     * @param string $resource
     * @return Endpoint|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    function get(string $tech, string $resource): Endpoint
    {
        $response = $this->getRequest("/endpoints/{$tech}/{$resource}");
        return $this->jsonMapper->map(json_decode($response->getBody()), new Endpoint());
    }

    /**
     * @param string $tech
     * @param string $resource
     * @param string $from
     * @param string $body The body of the message TODO: This is weird in the documentation.
     *   Report issue, because it is unclear if the body in the request has to be set or if
     *   the body is delivered via a string in the query parameter.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function sendMessageToEndpoint(string $tech, string $resource, string $from, string $body): void
    {
        $this->putRequest("/endpoints/{$tech}/{$resource}/sendMessage", ['from' => $from, 'body' => $body]);
    }
}