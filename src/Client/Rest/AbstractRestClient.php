<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Client\Rest;

use GuzzleHttp\Client as GuzzleClient;
use InvalidArgumentException;
use JsonException;
use Monolog\Logger;
use NgVoice\AriClient\{Collection\HttpMethods,
    Exception\AsteriskRestInterfaceException,
    Helper,
    Model\ModelInterface};
use Oktavlachs\DataMappingService\Collection\SourceNamingConventions;
use Oktavlachs\DataMappingService\DataMappingService;
use Psr\Http\Message\ResponseInterface;
use Throwable;

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
     * The root Uri to the Asterisk REST Interface
     */
    private string $rootUri;

    private GuzzleClient $restClient;

    private DataMappingService $dataMappingService;

    protected Logger $logger;

    /**
     * Resource constructor.
     *
     * @param Settings $settings AriRestClient
     * connection settings
     * @param GuzzleClient|null $guzzleClient GuzzleClient HTTP Connection Object
     * @param DataMappingService|null $dataMappingService To map JSON strings
     * onto an ARI Message objects
     * @param Logger|null $logger Instance to log messages with
     */
    public function __construct(
        Settings $settings,
        GuzzleClient $guzzleClient = null,
        DataMappingService $dataMappingService = null,
        Logger $logger = null
    ) {
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

        if ($dataMappingService === null) {
            $dataMappingService = new DataMappingService(
                SourceNamingConventions::LOWER_SNAKE_CASE
            );
        }

        $this->dataMappingService = $dataMappingService;

        if ($logger === null) {
            $logger = Helper::initLogger(static::class);
        }

        $this->logger = $logger;
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
     * @noinspection PhpRedundantCatchClauseInspection We know that
     * a JsonException can be thrown here because we explicitly set
     * the flag.
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

                // Throws InvalidArgumentException
                $this->dataMappingService->mapArrayOntoObject(
                    $modelAsArray,
                    $targetModelInstance
                );

                $resultArray[] = $targetModelInstance;
            }
        } catch (InvalidArgumentException | JsonException $e) {
            /*
             * This would only happen if Asterisk changed the design of its JSON
             * responses without documenting it, so it is a very unlikely event.
             * Just in case, we can make a log though,
             * so the error message doesn't get lost.
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

            $this->logger->error($errorMessage, [__FUNCTION__]);
        }
    }

    /**
     * Transform a ResponseInterface into a ARI model instance.
     *
     * @param ResponseInterface $response Request Response
     * @param ModelInterface $modelInterface The model instance to map onto
     */
    protected function responseToAriModelInstance(
        ResponseInterface $response,
        ModelInterface $modelInterface
    ): void {
        try {
            $this
                ->dataMappingService
                ->mapRawJsonOntoObject((string) $response->getBody(), $modelInterface);
        } catch (InvalidArgumentException $e) {
            /*
             * This would only happen if Asterisk changed the design of its JSON
             * responses without documenting it, so it is a very unlikely event
             * and mustn't stop the process. Just in case, we can make a log
             * though, so the error message doesn't get lost.
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

            $this->logger->error($errorMessage, [__FUNCTION__]);
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

        try {
            return $this->restClient->request(
                HttpMethods::GET,
                $fullUri,
                ['sink' => $pathToFile]
            );
        } catch (Throwable $e) {
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
        } catch (Throwable $e) {
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
        return $this->rootUri . $resourceUri;
    }
}
