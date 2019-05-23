<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\RestClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use JsonMapper;
use JsonMapper_Exception;
use Monolog\Logger;
use NgVoice\AriClient\{Exception\AsteriskRestInterfaceException, Helper, Models\Model};

/**
 * Class AriClient is a basic client for the Asterisk REST Interface.
 *
 * @package NgVoice\AriClient\RestClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
abstract class AsteriskRestInterfaceClient
{
    private const QUERY = 'query';

    private const GET = 'GET';

    private const POST = 'POST';

    private const PUT = 'PUT';

    private const DELETE = 'DELETE';

    /**
     * @var Client
     */
    private $guzzleClient;

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
     * AriClient constructor.
     *
     * @param AriRestClientSettings $ariRestClientSettings
     * @param Client $guzzleClient
     * @param JsonMapper $jsonMapper
     */
    public function __construct(
        AriRestClientSettings $ariRestClientSettings,
        Client $guzzleClient = null,
        JsonMapper $jsonMapper = null
    ) {
        $this->logger = Helper::initLogger(Helper::getShortClassName($this));

        $httpType = $ariRestClientSettings->isHttpsEnabled() ? 'https' : 'http';
        $baseUri = "{$httpType}://"
                   . "{$ariRestClientSettings->getHost()}:"
                   . "{$ariRestClientSettings->getPort()}/";

        $this->rootUri = $ariRestClientSettings->getRootUri();

        if ($guzzleClient === null) {
            $guzzleClient = new Client(
                [
                    'base_uri' => $baseUri,
                    'auth'     => [
                        $ariRestClientSettings->getAriUser(),
                        $ariRestClientSettings->getAriPassword(),
                    ],
                ]
            );
        }

        $this->guzzleClient = $guzzleClient;

        if ($jsonMapper === null) {
            $jsonMapper = new JsonMapper();
        }

        $this->jsonMapper = $jsonMapper;

        // Allow mapping to private and protected properties and setter methods
        $this->jsonMapper->bIgnoreVisibility = true;
        $this->jsonMapper->bExceptionOnUndefinedProperty = true;
    }

    /**
     * Send a GET Request to Asterisk, expecting a model instance.
     *
     * @param string $modelClassPath
     * @param string $uri
     * @param array $queryParameters
     * @return Model
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    protected function getModelRequest(
        string $modelClassPath,
        string $uri,
        array $queryParameters = []
    ): Model {
        $uri = "{$this->rootUri}{$uri}";
        $this->debugRequest(self::GET, $uri, $queryParameters);

        try {
            $response = $this->guzzleClient->request(
                self::GET,
                $uri,
                [self::QUERY => $queryParameters]
            );
        } catch (GuzzleException $e) {
            throw new AsteriskRestInterfaceException($e);
        }

        $this->debugResponse($response, self::GET, $uri, $queryParameters);

        return $this->mapJsonToAriModel($response, $modelClassPath);
    }

    /**
     * Send a GET Request to Asterisk, expecting an array of model instance.
     *
     * @param string $modelClassPath
     * @param string $uri
     * @param array $queryParameters
     *
     * @return Model[]
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    protected function getArrayOfModelInstancesRequest(
        string $modelClassPath,
        string $uri,
        array $queryParameters = []
    ): array {
        $uri = "{$this->rootUri}{$uri}";
        $this->debugRequest(self::GET, $uri, $queryParameters);

        try {
            $response = $this->guzzleClient->request(
                self::GET,
                $uri,
                [self::QUERY => $queryParameters]
            );
        } catch (GuzzleException $e) {
            throw new AsteriskRestInterfaceException($e);
        }

        $this->debugResponse($response, self::GET, $uri, $queryParameters);

        return $this->mapJsonToArrayOfAriModelInstances($response, $modelClassPath);
    }

    /**
     * Log requests for debugging purposes.
     *
     * @param string $method
     * @param string $uri
     * @param array $queryParameters
     * @param array $body
     */
    private function debugRequest(
        string $method,
        string $uri,
        array $queryParameters = [],
        array $body = []
    ): void {
        $queryParameters = print_r($queryParameters, true);
        $body = print_r($body, true);
        $this->logger->debug(
            "Sending Request... Method: {$method} | URI: {$uri} | "
            . "QueryParameters: {$queryParameters} | Body: {$body}"
        );
    }

    /**
     * Log responses for debugging purposes.
     *
     * @param Response $response
     * @param string $method
     * @param string $uri
     * @param array $queryParameters
     * @param array $body
     */
    private function debugResponse(
        Response $response,
        string $method,
        string $uri,
        array $queryParameters = [],
        array $body = []
    ): void {
        $queryParameters = print_r($queryParameters, true);
        $body = print_r($body, true);
        $this->logger->debug(
            "Received Response... Method: {$method} | URI: {$uri} | "
            . "QueryParameters: {$queryParameters} | Body: {$body} | "
            . "ResponseCode: {$response->getStatusCode()} | "
            . "Reason: {$response->getReasonPhrase()} | "
            . "Body: {$response->getBody()}"
        );
    }

    /**
     * @param Response $response
     * @param string $targetObjectType
     *
     * @return Model[]
     */
    private function mapJsonToArrayOfAriModelInstances(
        Response $response,
        string $targetObjectType
    ): array {
        $decodedResponseBody = json_decode((string) $response->getBody(), false);
        try {
            $mappedElements = [];
            foreach ($decodedResponseBody as $jsonObject) {
                $mappedElements[] =
                    $this->jsonMapper->map($jsonObject, new $targetObjectType());
            }

            return $mappedElements;
        } catch (JsonMapper_Exception $jsonMapper_Exception) {
            $this->logger->error($jsonMapper_Exception->getMessage());
            exit(1);
        }
    }

    /**
     * @param Response $response
     * @param string $modelClassPath
     *
     * @return Model|object
     */
    private function mapJsonToAriModel(Response $response, string $modelClassPath): Model
    {
        try {
            return $this->jsonMapper->map(
                json_decode((string) $response->getBody(), false),
                new $modelClassPath()
            );
        } catch (JsonMapper_Exception $jsonMapper_Exception) {
            $this->logger->error($jsonMapper_Exception->getMessage(), [__FUNCTION__]);
            // If the entity cannot be mapped, this is a show stopper.
            exit(1);
        }
    }

    /**
     * Send a POST request to Asterisk with no returning Model.
     *
     * @param string $uri
     * @param array $queryParameters
     * @param array $body
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    protected function postRequest(
        string $uri,
        array $queryParameters = [],
        array $body = []
    ): void {
        $uri = "{$this->rootUri}{$uri}";
        $this->debugRequest(self::POST, $uri, $queryParameters, $body);

        try {
            $response = $this->guzzleClient->request(
                self::POST,
                $uri,
                ['json' => $body, self::QUERY => $queryParameters]
            );
        } catch (GuzzleException $e) {
            throw new AsteriskRestInterfaceException($e);
        }

        $this->debugResponse($response, self::POST, $uri, $queryParameters, $body);
    }

    /**
     * Send a POST request to Asterisk and return a model instance.
     *
     * @param string $returnModelClassPath
     * @param string $uri
     * @param array $queryParameters
     * @param array $body
     *
     * @return Model
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    protected function postRequestReturningModel(
        string $returnModelClassPath,
        string $uri,
        array $queryParameters = [],
        array $body = []
    ): Model {
        $uri = "{$this->rootUri}{$uri}";
        $this->debugRequest(self::POST, $uri, $queryParameters, $body);

        try {
            $response = $this->guzzleClient->request(
                self::POST,
                $uri,
                ['json' => $body, self::QUERY => $queryParameters]
            );
        } catch (GuzzleException $e) {
            throw new AsteriskRestInterfaceException($e);
        }

        $this->debugResponse($response, self::POST, $uri, $queryParameters, $body);

        return $this->mapJsonToAriModel($response, $returnModelClassPath);
    }

    /**
     * Send a POST request to Asterisk and return an array of model instances.
     *
     * @param string $returnModelClassPath
     * @param string $uri
     * @param array $queryParameters
     * @param array $body
     *
     * @return Model[]
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    protected function postRequestReturningArrayOfModelInstances(
        string $returnModelClassPath,
        string $uri,
        array $queryParameters = [],
        array $body = []
    ): array {
        $uri = "{$this->rootUri}{$uri}";
        $this->debugRequest(self::POST, $uri, $queryParameters, $body);

        try {
            $response = $this->guzzleClient->request(
                self::POST,
                $uri,
                ['json' => $body, self::QUERY => $queryParameters]
            );
        } catch (GuzzleException $e) {
            throw new AsteriskRestInterfaceException($e);
        }

        $this->debugResponse($response, self::POST, $uri, $queryParameters, $body);

        return $this->mapJsonToArrayOfAriModelInstances($response, $returnModelClassPath);
    }

    /**
     * Send a PUT request to Asterisk and return a Model instance.
     *
     * @param string $returnModelClassPath
     * @param string $uri
     * @param array $body
     *
     * @return Model
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    protected function putRequestReturningModel(
        string $returnModelClassPath,
        string $uri,
        array $body = []
    ): Model {
        $uri = "{$this->rootUri}{$uri}";
        $this->debugRequest(self::PUT, $uri, [], $body);

        try {
            $response = $this->guzzleClient->request(self::PUT, $uri, ['json' => $body]);
        } catch (GuzzleException $e) {
            throw new AsteriskRestInterfaceException($e);
        }

        $this->debugResponse($response, self::PUT, $uri, [], $body);

        return $this->mapJsonToAriModel($response, $returnModelClassPath);
    }

    /**
     * Send a PUT request to Asterisk and return an array of Model instances.
     *
     * @param string $returnModelClassPath
     * @param string $uri
     * @param array $body
     *
     * @return Model[]
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    protected function putRequestReturningArrayOfModelInstances(
        string $returnModelClassPath,
        string $uri,
        array $body = []
    ): array {
        $uri = "{$this->rootUri}{$uri}";
        $this->debugRequest(self::PUT, $uri, [], $body);

        try {
            $response = $this->guzzleClient->request(self::PUT, $uri, ['json' => $body]);
        } catch (GuzzleException $e) {
            throw new AsteriskRestInterfaceException($e);
        }

        $this->debugResponse($response, self::PUT, $uri, [], $body);

        return $this->mapJsonToArrayOfAriModelInstances($response, $returnModelClassPath);
    }

    /**
     * Send a PUT request to Asterisk.
     *
     * @param string $uri
     * @param array $body
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    protected function putRequest(
        string $uri,
        array $body = []
    ): void {
        $uri = "{$this->rootUri}{$uri}";
        $this->debugRequest(self::PUT, $uri, [], $body);

        try {
            $response = $this->guzzleClient->request(self::PUT, $uri, ['json' => $body]);
        } catch (GuzzleException $e) {
            throw new AsteriskRestInterfaceException($e);
        }

        $this->debugResponse($response, self::PUT, $uri, [], $body);
    }

    /**
     * Send a DELETE request to Asterisk returning a Model instance.
     *
     * @param string $returnModelClassPath
     * @param string $uri
     * @param array $queryParameters
     *
     * @return Model
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    protected function deleteRequestReturningModel(
        string $returnModelClassPath,
        string $uri,
        array $queryParameters = []
    ): Model {
        $uri = "{$this->rootUri}{$uri}";
        $this->debugRequest(self::DELETE, $uri, $queryParameters);

        try {
            $response = $this->guzzleClient->request(
                self::DELETE,
                $uri,
                [self::QUERY => $queryParameters]
            );
        } catch (GuzzleException $e) {
            throw new AsteriskRestInterfaceException($e);
        }

        $this->debugResponse($response, self::DELETE, $uri, $queryParameters);

        return $this->mapJsonToAriModel($response, $returnModelClassPath);
    }

    /**
     * Send a DELETE request to Asterisk.
     *
     * @param string $uri
     * @param array $queryParameters
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    protected function deleteRequest(
        string $uri,
        array $queryParameters = []
    ): void {
        $uri = "{$this->rootUri}{$uri}";
        $this->debugRequest(self::DELETE, $uri, $queryParameters);

        try {
            $response = $this->guzzleClient->request(
                self::DELETE,
                $uri,
                [self::QUERY => $queryParameters]
            );
        } catch (GuzzleException $e) {
            throw new AsteriskRestInterfaceException($e);
        }

        $this->debugResponse($response, self::DELETE, $uri, $queryParameters);
    }

    /**
     * @param string $uri
     * @param string $pathToFile
     * @throws AsteriskRestInterfaceException
     */
    protected function downloadFile(string $uri, string $pathToFile): void
    {
        $uri = "{$this->rootUri}{$uri}";

        try {
            $this->guzzleClient->request(self::GET, $uri, ['sink' => $pathToFile]);
        } catch (GuzzleException $e) {
            throw new AsteriskRestInterfaceException($e);
        }
    }
}
