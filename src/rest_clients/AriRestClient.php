<?php
/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\rest_clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use JsonMapper;
use Monolog\Logger;
use function AriStasisApp\{getShortClassName, initLogger, parseAriSettings};

/**
 * Class AriRestClient
 *
 * @package AriStasisApp\rest_clients
 */
class AriRestClient
{
    /**
     * @var JsonMapper
     */
    protected $jsonMapper;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var Client
     */
    private $guzzleClient;

    /**
     * @var string
     */
    private $rootUri;

    /**
     * AriRestClient constructor.
     *
     * @param string $ariUser
     * @param string $ariPassword
     * @param array $otherAriSettings
     */
    function __construct(string $ariUser, string $ariPassword, array $otherAriSettings = [])
    {
        $ariSettings = parseAriSettings($otherAriSettings);
        $this->logger = initLogger(getShortClassName($this));

        $httpType = $ariSettings['httpsEnabled'] ? 'https' : 'http';
        $baseUri = "{$httpType}://{$ariSettings['host']}:{$ariSettings['port']}/";
        $this->rootUri = $ariSettings['rootUri'];
        $this->guzzleClient =
            new Client(['base_uri' => $baseUri, 'auth' => [$ariUser, $ariPassword]]);
        $this->jsonMapper = new JsonMapper();
        $this->jsonMapper->bIgnoreVisibility = true;
    }

    /**
     * Sends a POST request via a GuzzleClient to Asterisk.
     *
     * @param string $uri
     * @param array $queryParameters
     * @param array $body
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * @throws GuzzleException
     */
    protected function postRequest(string $uri, array $queryParameters = [], array $body = [])
    {
        $method = 'POST';
        $uri = $this->rootUri . $uri;
        try {
            $this->logRequest($method, $uri, $queryParameters, $body);
            $response = $this->guzzleClient->request($method, $uri, ['json' => $body, 'query' => $queryParameters]);
            $this->logResponse($response, $method, $uri);
            return $response;
        } catch (GuzzleException $guzzleException) {
            $this->logException($guzzleException, $method, $uri, $queryParameters, $body);
            throw $guzzleException;
        }
    }

    /**
     * Logs Requests for debugging purposes.
     *
     * @param string $method
     * @param string $uri
     * @param array $queryParameters
     * @param array $body
     */
    private function logRequest(string $method, string $uri, array $queryParameters = [], array $body = [])
    {
        $queryParameters = print_r($queryParameters, true);
        $body = print_r($body, true);
        $this->logger->debug("Sending Request... Method: {$method} | URI: {$uri} | "
            . "QueryParameters: {$queryParameters} | Body: {$body}");
    }

    /**
     * Logs Responses for debugging purposes.
     *
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
     * Logs Exceptions in case of an error.
     *
     * @param \Exception $e
     * @param string $method
     * @param string $uri
     * @param array $queryParameters
     * @param array $body
     */
    private function logException(
        \Exception $e,
        string $method,
        string $uri,
        array $queryParameters = [],
        array $body = []
    ) {
        $queryParameters = print_r($queryParameters, true);
        $body = print_r($body, true);
        $this->logger->error("Failed Request... ResponseCode: {$e->getCode()} | "
            . "Reason: {$e->getMessage()} | Method: {$method} | URI: {$uri} | "
            . "QueryParameters: {$queryParameters} | RequestBody: {$body}"
        );
    }

    /**
     * Sends a GET request via a GuzzleClient to Asterisk.
     *
     * @param string $uri
     * @param array $queryParameters
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * @throws GuzzleException
     */
    protected function getRequest(string $uri, array $queryParameters = [])
    {
        $method = 'GET';
        $uri = $this->rootUri . $uri;
        try {
            $this->logRequest($method, $uri, $queryParameters);
            $response = $this->guzzleClient->request($method, $uri, ['query' => $queryParameters]);
            $this->logResponse($response, $method, $uri);

            return $response;
        } catch (GuzzleException $guzzleException) {
            $this->logException($guzzleException, $method, $uri, $queryParameters);
            throw $guzzleException;
        }
    }


    /**
     * Sends a DELETE request via a GuzzleClient to Asterisk.
     *
     * @param string $uri
     * @param array $queryParameters
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * @throws GuzzleException
     */
    protected function deleteRequest(string $uri, array $queryParameters = [])
    {
        $method = 'DELETE';
        $uri = $this->rootUri . $uri;
        try {
            $this->logRequest($method, $uri, $queryParameters);
            $response = $this->guzzleClient->request($method, $uri, ['query' => $queryParameters]);
            $this->logResponse($response, $method, $uri);
            return $response;
        } catch (GuzzleException $guzzleException) {
            $this->logException($guzzleException, $method, $uri);
            throw $guzzleException;
        }
    }


    /**
     * Sends a PUT request via a GuzzleClient to Asterisk.
     *
     * @param string $uri
     * @param array $body
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * TODO: Check, if all extending clients only use the second parameter for BODY, not mistakenly query parameters
     * @throws GuzzleException
     */
    protected function putRequest(string $uri, array $body = [])
    {
        $method = 'PUT';
        $uri = $this->rootUri . $uri;
        try {
            $this->logRequest($method, $uri, [], $body);
            $response = $this->guzzleClient->request($method, $uri, ['json' => $body]);
            $this->logResponse($response, $method, $uri);
            return $response;
        } catch (GuzzleException $guzzleException) {
            $this->logException($guzzleException, $method, $uri, [], $body);
            throw $guzzleException;
        }
    }
}