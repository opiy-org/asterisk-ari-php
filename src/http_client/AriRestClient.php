<?php

/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\http_client;

use function AriStasisApp\{getShortClassName, initLogger, parseAriSettings};
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client;
use Monolog\Logger;

/**
 * Class AriRestClient
 *
 * @package AriStasisApp\rest_clients
 */
class AriRestClient
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var Client
     */
    protected $guzzleClient;

    /**
     * @var string
     */
    private $rootUri;

    /**
     * AriRestClient constructor.
     *
     * @param array $ariSettings
     */
    function __construct(array $ariSettings = [])
    {
        $settings = parseAriSettings($ariSettings);
        $this->logger = initLogger(getShortClassName($this));

        $httpType = $settings['https_enabled'] ? 'https' : 'http';
        // TODO: Parse rootUri, so there won't be conflicts with '/'
        $baseUri = "{$httpType}://{$settings['host']}:{$settings['port']}{$settings['rootUri']}";
        $this->rootUri = $settings['rootUri'];

        $this->guzzleClient =
            new Client(['base_uri' => $baseUri, 'auth' => [$settings['user'], $settings['password']]]);
    }

    /**
     * @param string $uri
     * @param array $body
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * TODO: Check, if all extending clients only use the second parameter for BODY, not mistakenly query parameters
     */
    function putRequest(string $uri, array $body = [])
    {
        $method = 'PUT';
        $uri = $this->rootUri . $uri;
        try {
            $this->logRequest($method, $uri, [], $body);
            $response = $this->guzzleClient->request($method, $uri, ['json' => $body]);
            $this->logResponse($response, $method, $uri);
            return $response;
        }
        catch (GuzzleException $e) {
            $this->logException($e, $method, $uri, [], $body);
            return false;
        }
    }


    /**
     * @param string $uri
     * @param array $queryParameters
     * @param array $body
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function postRequest(string $uri, array $queryParameters = [], array $body = [])
    {
        $method = 'POST';
        $uri = $this->rootUri . $uri;
        try {
            $this->logRequest($method, $uri, $queryParameters, $body);
            $response = $this->guzzleClient->request($method, $uri, ['json' => $body, 'query' => $queryParameters]);
            $this->logResponse($response, $method, $uri);
            return $response;
        }
        catch (GuzzleException $e) {
            $this->logException($e, $method, $uri, $queryParameters, $body);
            return false;
        }
    }

    /**
     * @param string $uri
     * @param array $queryParameters
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function getRequest(string $uri, array $queryParameters = [])
    {
        $method = 'GET';
        $uri = $this->rootUri . $uri;
        try {
            $this->logRequest($method, $uri, $queryParameters);
            $response = $this->guzzleClient->request($method, $uri, ['query' => $queryParameters]);
            $this->logResponse($response, $method, $uri);

            return $response;
        }
        catch (GuzzleException $e) {
            $this->logException($e, $method, $uri, $queryParameters);
            return false;
        }
    }

    /**
     * @param string $uri
     * @param array $queryParameters
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function deleteRequest(string $uri, array $queryParameters = [])
    {
        $method = 'DELETE';
        $uri = $this->rootUri . $uri;
        try {
            $this->logRequest($method, $uri, $queryParameters);
            $response = $this->guzzleClient->request($method, $uri, ['query' => $queryParameters]);
            $this->logResponse($response, $method, $uri);
            return $response;
        }
        catch (GuzzleException $e) {
            $this->logException($e, $method, $uri);
            return false;
        }
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $queryParameters
     * @param array $body
     */
    private function logRequest(string $method, string $uri,
                                  array $queryParameters = [], array $body = [])
    {
        $queryParameters = print_r($queryParameters, true);
        $body = print_r($body, true);
        $this->logger->debug("Sending Request... Method: {$method} | URI: {$uri} | "
                . "QueryParameters: {$queryParameters} | Body: {$body}");
    }

    /**
     * @param Response $response
     * @param string $method
     * @param string $uri
     */
    private function logResponse(Response $response, string $method, string $uri)
    {
        $this->logger->debug("Received Response... Method: {$method} | URI: {$uri} | "
            . "ResponseCode: {$response->getStatusCode()} | Reason: {$response->getReasonPhrase()} | "
            . "Body: {$response->getBody()}");
    }

    /**
     * @param \Exception $e
     * @param string $method
     * @param string $uri
     * @param array $queryParameters
     * @param array $body
     */
    private function logException(\Exception $e, string $method, string $uri,
                                  array $queryParameters = [], array $body = [])
    {
        $queryParameters = print_r($queryParameters, true);
        $body = print_r($body, true);
        $this->logger->error("Failed Request... ResponseCode: {$e->getCode()} | "
            . "Reason: {$e->getMessage()} | Method: {$method} | URI: {$uri} | "
            . "QueryParameters: {$queryParameters} | RequestBody: {$body}"
        );
    }
}