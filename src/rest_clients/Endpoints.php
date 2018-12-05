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


/**
 * Class Endpoints
 *
 * @package AriStasisApp\ariclients
 */
class Endpoints extends AriRestClient
{
    /**
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function list()
    {
        return $this->getRequest('/endpoints');
    }

    /**
     * @param string $to
     * @param string $from
     * @param string $body
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * TODO: This is weird in the documentation. Report issue, because it is unclear if the body in the request
     * has to be set or if the body is delivered via a string in the query parameter.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function sendMessage(string $to, string $from, string $body)
    {
        return $this->putRequest("/endpoints/sendMessage",
            ['to' => $to, 'from' => $from, 'body' => $body]);
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
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function get(string $tech, string $resource)
    {
        return $this->getRequest("/endpoints/{$tech}/{$resource}");
    }

    /**
     * @param string $tech
     * @param string $resource
     * @param string $from
     * @param string $body The body of the message
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * TODO: This is weird in the documentation. Report issue, because it is unclear if the body in the request
     * has to be set or if the body is delivered via a string in the query parameter.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function sendMessageToEndpoint(string $tech, string $resource, string $from, string $body)
    {
        return $this->putRequest("/endpoints/{$tech}/{$resource}/sendMessage",
            ['from' => $from, 'body' => $body]);
    }
}