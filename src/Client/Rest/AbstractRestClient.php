<?php

/**
 * @copyright 2020 ng-voice GmbH
 *
 * @noinspection UnknownInspectionInspection The [EA] extended
 * plugin doesn't know about the noinspection annotation.
 */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Client\Rest;

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\Source;
use CuyZ\Valinor\Mapper\TreeMapper;
use CuyZ\Valinor\MapperBuilder;
use GuzzleHttp\Client as GuzzleClient;
use JsonException;
use OpiyOrg\AriClient\Enum\HttpMethods;
use OpiyOrg\AriClient\Exception\AsteriskRestInterfaceException;
use OpiyOrg\AriClient\Helper;
use OpiyOrg\AriClient\Model\ModelInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Throwable;
use TypeError;

/**
 * A basic HTTP client for the Asterisk REST Interface.
 *
 * @package OpiyOrg\AriClient\RestClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
abstract class AbstractRestClient
{
    protected TreeMapper $dataMappingService;

    protected LoggerInterface $logger;

    private string $rootUri;

    private GuzzleClient $httpClient;

    private bool $isInDebugMode;

    /**
     * Resource constructor.
     *
     * @param Settings $abstractClientSettings AriRestClient
     * connection settings
     * @param GuzzleClient|null $httpClient GuzzleClient HTTP Connection Object
     */
    public function __construct(
        Settings $abstractClientSettings,
        ?GuzzleClient $httpClient = null
    ) {
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
                    'auth' => [
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

        $this->dataMappingService = (new MapperBuilder())
            ->enableFlexibleCasting()
            ->allowSuperfluousKeys()
            ->allowPermissiveTypes()
            ->mapper();

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
     * @throws JsonException
     * returns an invalid response
     */
    protected function responseToArrayOfAriModelInstances(
        ResponseInterface $response,
        ModelInterface $ariModelInterface,
        array &$resultArray
    ): void {
        try {
            $decodedResponseBody = json_decode(
                (string)$response->getBody(),
                true,
                512,
                JSON_THROW_ON_ERROR
            );

            foreach ($decodedResponseBody as $modelAsArray) {
                $targetModelInstance = $this->dataMappingService
                    ->map(
                        $ariModelInterface::class,
                        Source::array($modelAsArray)->camelCaseKeys()
                    );

                $resultArray[] = $targetModelInstance;
            }
        } catch (MappingError $exception) {
            /*
             * This would only happen if Asterisk changed the design of its JSON
             * responses without documenting it, so it is a very unlikely event.
             */
            $concatenatedExceptionMessages = $exception->getMessage();

            if ($exception->getPrevious() !== null) {
                $concatenatedExceptionMessages .=
                    ' ------> ' . $exception->getPrevious()->getMessage();
            }

            $errorMessage = sprintf(
                "%s: Event -> '%s' HTTP response body was: '%s'",
                get_class($exception),
                $concatenatedExceptionMessages,
                $response->getBody()
            );

            throw new AsteriskRestInterfaceException(
                new TypeError($errorMessage, $exception->getCode(), $exception)
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
     * @throws JsonException
     * returns an invalid response
     */
    protected function responseToAriModelInstance(
        ResponseInterface $response,
        ModelInterface &$modelInterface
    ): void {
        try {
            $decodedResponseBody = json_decode(
                (string)$response->getBody(),
                true,
                512,
                JSON_THROW_ON_ERROR
            );

            $modelInterface = $this->dataMappingService
                ->map(
                    $modelInterface::class,
                    Source::array($decodedResponseBody)->camelCaseKeys()
                );
        } catch (MappingError $exception) {
            /*
             * This would only happen if Asterisk changed the design of its JSON
             * responses without documenting it, so it is a very unlikely event.
             */
            $concatenatedExceptionMessages = $exception->getMessage();

            if ($exception->getPrevious() !== null) {
                $concatenatedExceptionMessages .=
                    ' ------> ' . $exception->getPrevious()->getMessage();
            }

            $errorMessage = sprintf(
                "Asterisk response couldn't be mapped onto Model '%s': '%s' "
                . "HTTP response body was: '%s'",
                get_class($modelInterface),
                $concatenatedExceptionMessages,
                $response->getBody()
            );

            throw new AsteriskRestInterfaceException(
                new TypeError($errorMessage, $exception->getCode(), $exception)
            );
        }
    }

    /**
     * Send HTTP request to the Asterisk REST Interface,
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
     * Send HTTP request to the Asterisk REST Interface.
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
