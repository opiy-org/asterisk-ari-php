<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\RestClient;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use JsonMapper;
use JsonMapper_Exception;
use Monolog\Logger;
use NgVoice\AriClient\{Collection\HttpMethods,
    Exception\AsteriskRestInterfaceException,
    Helper,
    Models\ModelInterface};
use Psr\Http\Message\ResponseInterface;

/**
 * A basic HTTP client for the Asterisk REST Interface.
 *
 * @package NgVoice\AriClient\RestClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
abstract class AbstractRestClient
{
    /**
     * @var GuzzleClient
     */
    private $restClient;

    /**
     * @var JsonMapper
     */
    private $jsonMapper;

    /**
     * @var string
     */
    private $rootUri;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * ResourceClient constructor.
     *
     * @param Settings $settings AriRestClient
     * connection settings
     * @param GuzzleClient|null $guzzleClient GuzzleClient HTTP Connection Object
     * @param JsonMapper|null $jsonMapper To convert JSON into an Ari Messages
     */
    public function __construct(
        Settings $settings,
        GuzzleClient $guzzleClient = null,
        JsonMapper $jsonMapper = null
    ) {
        $this->logger = Helper::initLogger(static::class);

        $httpType = $settings->isHttpsEnabled() ? 'https' : 'http';

        $baseUri = sprintf(
            '%s://%s:%u/',
            $httpType,
            $settings->getHost(),
            $settings->getPort()
        );

        $this->rootUri = $settings->getRootUri();

        if ($guzzleClient === null) {
            $guzzleClient = new GuzzleClient(
                [
                    'base_uri' => $baseUri,
                    'auth'     => [
                        $settings->getUser(),
                        $settings->getPassword(),
                    ],
                ]
            );
        }

        $this->restClient = $guzzleClient;

        if ($jsonMapper === null) {
            $jsonMapper = new JsonMapper();
        }

        $this->jsonMapper = $jsonMapper;

        // Allow mapping to private and protected properties and setter methods
        $this->jsonMapper->bIgnoreVisibility = true;
        $this->jsonMapper->bExceptionOnUndefinedProperty = true;
    }

    /**
     * Log requests for debugging purposes.
     *
     * @param string $method Request Method
     * @param string $resourceUri URI Path
     * @param array $queryParameters Array of Query Parameters
     * @param array $body Body Content
     */
    private function debugRequest(
        string $method,
        string $resourceUri,
        array $queryParameters = [],
        array $body = []
    ): void {
        $this->logger->debug(
            sprintf(
                "Sending Request... Method: '%s' | URI: '%s' | "
                . "QueryParameters: '%s' | Body: '%s'",
                $method,
                $this->appendToRootUri($resourceUri),
                print_r($queryParameters, true),
                print_r($body, true)
            ),
            [__FUNCTION__]
        );
    }

    /**
     * Log responses for debugging purposes.
     *
     * @param ResponseInterface $response Request Response
     * @param string $method Request Method
     * @param string $resourceUri URI Path
     * @param array $queryParameters Array of Query Parameters
     * @param array $body Body Content
     */
    private function debugResponse(
        ResponseInterface $response,
        string $method,
        string $resourceUri,
        array $queryParameters = [],
        array $body = []
    ): void {
        $this->logger->debug(
            sprintf(
                "Received response for request with Method: '%s' | URI: '%s' | "
                . "QueryParameters: '%s' | RequestBody: '%s' ------> ResponseCode: '%u'"
                . " | Reason: '%s' | ResponseBody: '%s'",
                $method,
                $this->appendToRootUri($resourceUri),
                print_r($queryParameters, true),
                print_r($body, true),
                $response->getStatusCode(),
                $response->getReasonPhrase(),
                $response->getBody()
            ),
            [__FUNCTION__]
        );
    }

    /**
     * Transform a ResponseInterface into an array of ARI model instances.
     *
     * @param ResponseInterface $response Request Response
     * @param ModelInterface $ariModelInterface Class path of the target ARI model
     *
     * @param ModelInterface[] $resultArray Collection of mapped ModelInterface
     * instances.
     *
     * @throws AsteriskRestInterfaceException In case the JSON response could
     * not map onto an ARI model object. Although this is not an HTTP error
     */
    protected function responseToArrayOfAriModelInstances(
        ResponseInterface $response,
        ModelInterface $ariModelInterface,
        array &$resultArray
    ): void {
        try {
            // Throws JsonException
            $decodedResponseBody = json_decode(
                (string) $response->getBody(),
                false,
                512,
                JSON_THROW_ON_ERROR
            );

            foreach ($decodedResponseBody as $jsonObject) {
                // Throws JsonMapper_Exception
                $resultArray[] = $this
                    ->jsonMapper
                    ->map($jsonObject, $ariModelInterface);
            }
        } catch (JsonMapper_Exception $jsonMapperException) {
            throw new AsteriskRestInterfaceException($jsonMapperException);
        }
    }

    /**
     * Transform a ResponseInterface into a ARI model instance.
     *
     * @param ResponseInterface $response Request Response
     * @param ModelInterface $modelInterface The model instance to map onto
     *
     * @throws AsteriskRestInterfaceException In case the JSON response could
     * not map onto an ARI model object. Although this is not an HTTP error
     */
    protected function responseToAriModelInstance(
        ResponseInterface $response,
        ModelInterface $modelInterface
    ): void {
        try {
            // Throws JsonException
            $decodedResponseBody = json_decode(
                (string) $response->getBody(),
                false,
                512,
                JSON_THROW_ON_ERROR
            );

            // Throws JsonMapper_Exception
            $this->jsonMapper->map($decodedResponseBody, $modelInterface);
        } catch (JsonMapper_Exception $jsonMapperException) {
            throw new AsteriskRestInterfaceException($jsonMapperException);
        }
    }

    /**
     * Send a HTTP request to the Asterisk REST Interface,
     * intending to download a file.
     *
     * @param string $resourceUri URI Path
     * @param string $pathToFile File Path
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    protected function sendDownloadFileRequest(
        string $resourceUri,
        string $pathToFile
    ): void {
        $fullUri = $this->appendToRootUri($resourceUri);

        try {
            $this->restClient->request(
                HttpMethods::GET,
                $fullUri,
                ['sink' => $pathToFile]
            );
        } catch (GuzzleException $e) {
            throw new AsteriskRestInterfaceException($e);
        }
    }

    /**
     * Send a HTTP request to the Asterisk REST Interface.
     *
     * @param string $method The HTTP method that shall be used
     * @param string $resourceUri The requested resources URI
     * @param array $queryParameters The query parameters
     * @param array $body The body
     *
     * @return ResponseInterface
     *
     * @throws AsteriskRestInterfaceException in case the ARI request fails
     */
    protected function sendRequest(
        string $method,
        string $resourceUri,
        array $queryParameters = [],
        array $body = []
    ): ResponseInterface {
        $this->debugRequest($method, $resourceUri, $queryParameters, $body);

        $requestOptions = [];

        if ($queryParameters !== []) {
            $requestOptions['query'] = $queryParameters;
        }

        if ($body !== []) {
            $requestOptions['json'] = $body;
        }

        try {
            $response = $this->restClient->request(
                $method,
                $this->appendToRootUri($resourceUri),
                $requestOptions
            );
        } catch (GuzzleException $e) {
            throw new AsteriskRestInterfaceException($e);
        }

        $this->debugResponse($response, $method, $resourceUri, $queryParameters, $body);

        return $response;
    }

    /**
     * Append a URI to the root URI of this REST client.
     *
     * @param string $resourceUri The URI to append to the root URI
     *
     * @return string
     */
    private function appendToRootUri(string $resourceUri): string
    {
        return sprintf("%s%s", $this->rootUri, $resourceUri);
    }
}
