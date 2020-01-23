<?php

/**
 * @copyright 2020 ng-voice GmbH
 *
 * @noinspection UnknownInspectionInspection The [EA] extended
 * plugin doesn't know about the noinspection annotation.
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Client\Rest;

use Throwable;
use JsonException;
use Psr\Log\LoggerInterface;
use NgVoice\AriClient\Helper;
use GuzzleHttp\Client as GuzzleClient;
use NgVoice\AriClient\Enum\HttpMethods;
use Psr\Http\Message\ResponseInterface;
use NgVoice\AriClient\Model\ModelInterface;
use Oktavlachs\DataMappingService\DataMappingService;
use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use Oktavlachs\DataMappingService\Collection\SourceNamingConventions;
use Oktavlachs\DataMappingService\Exception\DataMappingServiceException;
use TypeError;

/**
 * A basic HTTP client for the Asterisk REST Interface.
 *
 * @package NgVoice\AriClient\RestClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
abstract class AbstractRestClient
{
    private string $rootUri;

    private GuzzleClient $httpClient;

    private DataMappingService $dataMappingService;

    protected LoggerInterface $logger;

    private bool $isInDebugMode;

    /**
     * Resource constructor.
     *
     * @param Settings $abstractClientSettings AriRestClient
     * connection settings
     * @param GuzzleClient|null $httpClient GuzzleClient HTTP Connection Object
     */
    public function __construct(Settings $abstractClientSettings, GuzzleClient $httpClient = null)
    {
        $httpType = $abstractClientSettings->isHttpsEnabled() ? 'https' : 'http';

        $baseUri = sprintf(
            '%s://%s:%u/',
            $httpType,
            $abstractClientSettings->getHost(),
            $abstractClientSettings->getPort()
        );

        $this->rootUri = $abstractClientSettings->getRootUri();

        if ($httpClient === null) {
            $httpClient = new GuzzleClient(
                [
                    'base_uri' => $baseUri,
                    'auth'     => [
                        $abstractClientSettings->getUser(),
                        $abstractClientSettings->getPassword(),
                    ],
                ]
            );
        }

        $this->httpClient = $httpClient;

        $logger = $abstractClientSettings->getLoggerInterface();

        if ($logger === null) {
            $logger = Helper::initLogger(static::class);
        }

        $this->logger = $logger;

        $this->dataMappingService = new DataMappingService(
            SourceNamingConventions::LOWER_SNAKE_CASE
        );

        $this->dataMappingService->setIsUsingTargetObjectSetters(false);
        $this->isInDebugMode = $abstractClientSettings->isInDebugMode();
    }

    /**
     * Log requests for debugging purposes.
     *
     * @param string $method Request Method
     * @param string $resourceUri URI Path
     * @param array<int|string, int|string> $queryParameters Array of Query Parameters
     * @param array<string, int|string> $body Body Content
     */
    private function debugRequest(
        string $method,
        string $resourceUri,
        array $queryParameters = [],
        array $body = []
    ): void {
        $debugMessage = sprintf(
            "Sending Request... Method: '%s' | URI: '%s' | "
            . "QueryParameters: '%s' | Body: '%s'",
            $method,
            $this->appendToRootUri($resourceUri),
            print_r($queryParameters, true),
            print_r($body, true)
        );

        $this->logger->debug($debugMessage, [__FUNCTION__]);
    }

    /**
     * Log responses for debugging purposes.
     *
     * @param ResponseInterface $response Request Response
     * @param string $method Request Method
     * @param string $resourceUri URI Path
     * @param array<string, string> $queryParameters Array of Query Parameters
     * @param array<string, mixed> $body Body Content
     */
    private function debugResponse(
        ResponseInterface $response,
        string $method,
        string $resourceUri,
        array $queryParameters = [],
        array $body = []
    ): void {
        $debugMessage = sprintf(
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
        );

        $this->logger->debug($debugMessage, [__FUNCTION__]);
    }

    /**
     * Transform a ResponseInterface into an array of ARI model instances.
     *
     * @param ResponseInterface $response Request Response
     * @param ModelInterface $ariModelInterface Class path of the target ARI model
     *
     * @param ModelInterface[] $resultArray Collection of mapped ModelInterface
     * instances
     *
     * @return void
     *
     * @throws AsteriskRestInterfaceException In case the Asterisk REST Interface
     * returns an invalid response
     */
    protected function responseToArrayOfAriModelInstances(
        ResponseInterface $response,
        ModelInterface $ariModelInterface,
        array &$resultArray
    ): void {
        try {
            // Throws JsonException
            /** @var array<int, array<mixed>> $decodedResponseBody */
            $decodedResponseBody = json_decode(
                (string) $response->getBody(),
                true,
                512,
                JSON_THROW_ON_ERROR
            );

            $ariModelClassName = get_class($ariModelInterface);

            foreach ($decodedResponseBody as $modelAsArray) {
                $targetModelInstance = new $ariModelClassName();

                // Throws DataMappingServiceException
                $this->dataMappingService->mapArrayOntoObject(
                    $modelAsArray,
                    $targetModelInstance
                );

                $resultArray[] = $targetModelInstance;
            }
        }
        /** @noinspection PhpRedundantCatchClauseInspection We know that
         * a JsonException can be thrown here because we explicitly set
         * the flag.
         */
        catch (DataMappingServiceException | JsonException $e) {
            /*
             * This would only happen if Asterisk changed the design of its JSON
             * responses without documenting it, so it is a very unlikely event.
             */
            $concatenatedExceptionMessages = $e->getMessage();

            if ($e->getPrevious() !== null) {
                $concatenatedExceptionMessages .=
                    ' ------> ' . $e->getPrevious()->getMessage();
            }

            $errorMessage = sprintf(
                "%s: Event -> '%s' HTTP response body was: '%s'",
                get_class($e),
                $concatenatedExceptionMessages,
                (string) $response->getBody()
            );

            throw new AsteriskRestInterfaceException(
                new TypeError($errorMessage, $e->getCode(), $e)
            );
        }
    }

    /**
     * Transform a ResponseInterface into a ARI model instance.
     *
     * @param ResponseInterface $response Request Response
     * @param ModelInterface $modelInterface The model instance to map onto
     *
     * @throws AsteriskRestInterfaceException In case the Asterisk REST Interface
     * returns an invalid response
     */
    protected function responseToAriModelInstance(
        ResponseInterface $response,
        ModelInterface $modelInterface
    ): void {
        try {
            $this
                ->dataMappingService
                ->mapRawJsonOntoObject((string) $response->getBody(), $modelInterface);
        } catch (DataMappingServiceException $e) {
            /*
             * This would only happen if Asterisk changed the design of its JSON
             * responses without documenting it, so it is a very unlikely event.
             */
            $concatenatedExceptionMessages = $e->getMessage();

            if ($e->getPrevious() !== null) {
                $concatenatedExceptionMessages .=
                    ' ------> ' . $e->getPrevious()->getMessage();
            }

            $errorMessage = sprintf(
                "Asterisk response couldn't be mapped onto Model '%s': '%s' "
                . "HTTP response body was: '%s'",
                get_class($modelInterface),
                $concatenatedExceptionMessages,
                (string) $response->getBody()
            );

            throw new AsteriskRestInterfaceException(
                new TypeError($errorMessage, $e->getCode(), $e)
            );
        }
    }

    /**
     * Send a HTTP request to the Asterisk REST Interface,
     * intending to download a file.
     *
     * @param string $resourceUri URI Path
     * @param string $pathToFile File Path
     *
     * @return ResponseInterface The response of the server
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    protected function sendDownloadFileRequest(
        string $resourceUri,
        string $pathToFile
    ): ResponseInterface {
        $fullUri = $this->appendToRootUri($resourceUri);

        if ($this->isInDebugMode) {
            $this->debugRequest(HttpMethods::GET, $resourceUri, [], []);
        }

        try {
            $response = $this->httpClient->request(
                HttpMethods::GET,
                $fullUri,
                ['sink' => $pathToFile]
            );
        } catch (Throwable $e) {
            throw new AsteriskRestInterfaceException($e);
        }

        if ($this->isInDebugMode) {
            $this->debugResponse($response, HttpMethods::GET, $resourceUri, [], []);
        }

        return $response;
    }

    /**
     * Send a HTTP request to the Asterisk REST Interface.
     *
     * @param string $method The HTTP method that shall be used
     * @param string $resourceUri The requested resources URI
     * @param array<string, string> $queryParameters The query parameters
     * @param array<string, mixed> $body The body
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
        if ($this->isInDebugMode) {
            $this->debugRequest($method, $resourceUri, $queryParameters, $body);
        }

        $requestOptions = [];

        if ($queryParameters !== []) {
            $requestOptions['query'] = $queryParameters;
        }

        if ($body !== []) {
            $requestOptions['json'] = $body;
        }

        try {
            $response = $this->httpClient->request(
                $method,
                $this->appendToRootUri($resourceUri),
                $requestOptions
            );
        } catch (Throwable $e) {
            throw new AsteriskRestInterfaceException($e);
        }

        if ($this->isInDebugMode) {
            $this->debugResponse(
                $response,
                $method,
                $resourceUri,
                $queryParameters,
                $body
            );
        }

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
        return $this->rootUri . $resourceUri;
    }
}
