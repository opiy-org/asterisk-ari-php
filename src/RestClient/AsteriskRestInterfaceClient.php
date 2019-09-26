<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\RestClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonMapper;
use JsonMapper_Exception;
use Monolog\Logger;
use NgVoice\AriClient\{Exception\AsteriskRestInterfaceException,
    Helper,
    Models\ModelInterface};
use Psr\Http\Message\ResponseInterface;

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
     * @param AriRestClientSettings $ariRestClientSettings AriRestClient
     * connection setting
     * @param Client|null $guzzleClient GuzzleClient HTTP Connection Object
     * @param JsonMapper|null $jsonMapper To convert JSON into an Ari Messages
     */
    public function __construct(
        AriRestClientSettings $ariRestClientSettings,
        Client $guzzleClient = null,
        JsonMapper $jsonMapper = null
    ) {
        $this->logger = Helper::initLogger(static::class);

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
     * @param string $modelClassPath Path to a ModelInterface Class
     * @param string $uri URI Path
     * @param array $queryParameters Array of Query Parameters
     *
     * @return ModelInterface
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    protected function getModelRequest(
        string $modelClassPath,
        string $uri,
        array $queryParameters = []
    ): ModelInterface {
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
     * @param string $returnModelClassPath Path of a ModelInterface Class
     * @param string $uri URI Path
     * @param array $queryParameters Array of Query Parameters
     *
     * @return ModelInterface[]
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    protected function requestGetArrayOfModels(
        string $returnModelClassPath,
        string $uri,
        array $queryParameters = []
    ) {
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

        return $this->mapJsonToArrayOfAriModelInstances($response, $returnModelClassPath);
    }

    /**
     * Log requests for debugging purposes.
     *
     * @param string $method Request Method
     * @param string $uri URI Path
     * @param array $queryParameters Array of Query Parameters
     * @param array $body Body Content
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
     * @param ResponseInterface $response Request Response
     * @param string $method Request Method
     * @param string $uri URI Path
     * @param array $queryParameters Array of Query Parameters
     * @param array $body Body Content
     */
    private function debugResponse(
        ResponseInterface $response,
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
     * @param ResponseInterface $response Request Response
     * @param string $targetObjectType Path of the Target Object
     *
     * @return ModelInterface[]
     */
    private function mapJsonToArrayOfAriModelInstances(
        ResponseInterface $response,
        string $targetObjectType
    ) {
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
     * @param ResponseInterface $response Request Response
     * @param string $modelClassPath ModelInterface Class Path
     *
     * @return ModelInterface
     */
    private function mapJsonToAriModel(
        ResponseInterface $response,
        string $modelClassPath
    ): ModelInterface {
        try {
            /** @var ModelInterface $modelInterface */
            $modelInterface = $this->jsonMapper->map(
                json_decode((string) $response->getBody(), false),
                new $modelClassPath()
            );

            return $modelInterface;
        } catch (JsonMapper_Exception $jsonMapper_Exception) {
            $this->logger->error($jsonMapper_Exception->getMessage(), [__FUNCTION__]);
            // If the entity cannot be mapped, this is a show stopper.
            exit(1);
        }
    }

    /**
     * Send a POST request to Asterisk with no returning ModelInterface.
     *
     * @param string $uri URI Path
     * @param array $queryParameters Array of Query Parameters
     * @param array $body Body Content
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
     * @param string $returnModelClassPath ModelInterface Class Path
     * @param string $uri URI Path
     * @param array $queryParameters Array of Query Parameters
     * @param array $body Body Content
     *
     * @return ModelInterface
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    protected function postRequestReturningModel(
        string $returnModelClassPath,
        string $uri,
        array $queryParameters = [],
        array $body = []
    ): ModelInterface {
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
     * Send a PUT request to Asterisk and return a ModelInterface instance.
     *
     * @param string $returnModelClassPath ModelInterface Class Path
     * @param string $uri URI Path
     * @param array $body Body Content
     *
     * @return ModelInterface
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    protected function putRequestReturningModel(
        string $returnModelClassPath,
        string $uri,
        array $body = []
    ): ModelInterface {
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
     * Send a PUT request to Asterisk and return an array of ModelInterface instances.
     *
     * @param string $returnModelClassPath ModelInterface Class Path
     * @param string $uri URI Path
     * @param array $body Body Content
     *
     * @return ModelInterface[]
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    protected function putRequestReturningArrayOfModelInstances(
        string $returnModelClassPath,
        string $uri,
        array $body = []
    ) {
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
     * @param string $uri URI Path
     * @param array $body Body Content
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
            $response = $this->guzzleClient->request(
                self::PUT,
                $uri,
                ['json' => $body]
            );
        } catch (GuzzleException $e) {
            throw new AsteriskRestInterfaceException($e);
        }

        $this->debugResponse($response, self::PUT, $uri, [], $body);
    }

    /**
     * Send a DELETE request to Asterisk returning a ModelInterface instance.
     *
     * @param string $returnModelClassPath ModelInterface Class Path
     * @param string $uri URI Path
     * @param array $queryParameters Array of Query Parameters
     *
     * @return ModelInterface
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    protected function deleteRequestReturningModel(
        string $returnModelClassPath,
        string $uri,
        array $queryParameters = []
    ): ModelInterface {
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
     * @param string $uri URI Path
     * @param array $queryParameters Array of Query Parameters
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
     * @param string $uri URI Path
     * @param string $pathToFile File Path
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    protected function downloadFile(string $uri, string $pathToFile): void
    {
        $uri = "{$this->rootUri}{$uri}";

        try {
            $this->guzzleClient->request(
                self::GET,
                $uri,
                ['sink' => $pathToFile]
            );
        } catch (GuzzleException $e) {
            throw new AsteriskRestInterfaceException($e);
        }
    }
}
