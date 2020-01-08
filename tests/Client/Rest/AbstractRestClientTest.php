<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\RestClient {

    use NgVoice\AriClient\Model\Channel;
    use stdClass;

    /**
     * (PHP 5 &gt;= 5.2.0, PECL json &gt;= 1.2.0)<br/>
     * Decodes a JSON string
     *
     * @link https://php.net/manual/en/function.json-decode.php
     *
     * @param string $json <p>
     * The <i>json</i> string being decoded.
     * </p>
     * <p>
     * This function only works with UTF-8 encoded strings.
     * </p>
     * <p>PHP implements a superset of
     * JSON - it will also encode and decode scalar types and <b>NULL</b>. The JSON
     * standard
     * only supports these values when they are nested inside an array or an object.
     * </p>
     * @param bool $assoc [optional] <p>
     * When <b>TRUE</b>, returned objects will be converted into
     * associative arrays.
     * </p>
     * @param int $depth [optional] <p>
     * User specified recursion depth.
     * </p>
     * @param int $options [optional] <p>
     * Bitmask of JSON decode options. Currently only
     * <b>JSON_BIGINT_AS_STRING</b>
     * is supported (default is to cast large integers as floats)
     *
     * <b>JSON_THROW_ON_ERROR</b> when passed this flag, the error behaviour of these
     * functions is changed. The global error state is left untouched, and if an error
     * occurs that would otherwise set it, these functions instead throw a JsonException
     * </p>
     *
     * @return mixed the value encoded in <i>json</i> in appropriate
     * PHP type. Values true, false and
     * null (case-insensitive) are returned as <b>TRUE</b>, <b>FALSE</b>
     * and <b>NULL</b> respectively. <b>NULL</b> is returned if the
     * <i>json</i> cannot be decoded or if the encoded
     * data is deeper than the recursion limit.
     */
    function json_decode($json, $assoc = false, $depth = 512, $options = 0)
    {
        if ($json === 'testDataArrayOfModels') {
            return [new Channel(), new Channel()];
        }

        if ($json === 'dummyDataTestSendRequest') {
            return new stdClass();
        }

        return \json_decode($json, $assoc, 512, JSON_THROW_ON_ERROR);
    }
}

namespace NgVoice\AriClient\Tests\Client\Rest {

    use GuzzleHttp\Client as GuzzleClient;
    use GuzzleHttp\Exception\ClientException;
    use InvalidArgumentException;
    use Monolog\Logger;
    use NgVoice\AriClient\Client\Rest\{AbstractRestClient, Settings};
    use NgVoice\AriClient\Collection\HttpMethods;
    use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
    use NgVoice\AriClient\Model\{AsteriskPing, Channel, ModelInterface};
    use Oktavlachs\DataMappingService\DataMappingService;
    use PHPUnit\Framework\TestCase;
    use Psr\Http\Message\RequestInterface;
    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\StreamInterface;

    /**
     * Class AbstractRestClientTest
     *
     * @package NgVoice\AriClient\Tests\Rest
     *
     * @author Ahmad Hussain <ahmad@ng-voice.com>
     */
    class AbstractRestClientTest extends TestCase
    {
        public function testCreate(): void
        {
            $settings = $this->createMock(Settings::class);
            $guzzleClient = $this->createMock(GuzzleClient::class);
            $dataMappingService = $this->createMock(DataMappingService::class);

            $this->assertInstanceOf(
                AbstractRestClient::class,
                $this->getMockForAbstractClass(
                    AbstractRestClient::class,
                    [$settings, $guzzleClient, $dataMappingService]
                )
            );

            $settings->method('getHost')->willReturn('local-test-host');
            $settings->method('getPort')->willReturn(8088);

            $this->assertInstanceOf(
                AbstractRestClient::class,
                $this->getMockForAbstractClass(
                    AbstractRestClient::class,
                    [$settings]
                )
            );
        }

        public function testSendRequest(): ResponseInterface
        {
            $settings = $this->createMock(Settings::class);
            $guzzleClient = $this->createMock(GuzzleClient::class);
            $dataMappingService = $this->createMock(DataMappingService::class);

            $restClientExtensionClass = new class (
                $settings,
                $guzzleClient,
                $dataMappingService
            ) extends AbstractRestClient
            {
                public function triggerSendRequest(
                    string $uri,
                    array $queryParameters,
                    array $body
                ): ResponseInterface {
                    return $this->sendRequest(
                        HttpMethods::GET,
                        $uri,
                        $queryParameters,
                        $body
                    );
                }
            };

            $streamInterface = $this->createMock(StreamInterface::class);
            $streamInterface
                ->method('__toString')
                ->willReturn('{"dummyDataTestSendRequest":"Jo"}');

            $responseInterface = $this->createMock(ResponseInterface::class);
            $responseInterface->method('getBody')->willReturn($streamInterface);

            $guzzleClient
                ->method('request')
                ->willReturn(
                    $responseInterface
                );

            $response = $restClientExtensionClass->triggerSendRequest(
                '/someResource',
                ['some' => 'queryParameter'],
                ['some' => 'bodyParameter']
            );

            $this->assertInstanceOf(ResponseInterface::class, $response);

            return $response;
        }

        public function testSendRequestThrowsAriException(): void
        {
            $settings = $this->createMock(Settings::class);
            $guzzleClient = $this->createMock(GuzzleClient::class);
            $dataMappingService = $this->createMock(DataMappingService::class);

            $restClientExtensionClass = new class (
                $settings,
                $guzzleClient,
                $dataMappingService
            ) extends AbstractRestClient
            {
                public function triggerSendRequest(
                    string $uri,
                    array $queryParameters,
                    array $body
                ): ResponseInterface {
                    return $this->sendRequest(
                        HttpMethods::GET,
                        $uri,
                        $queryParameters,
                        $body
                    );
                }
            };

            $guzzleClient
                ->method('request')
                ->willThrowException(
                    new ClientException(
                        'Client error',
                        $this->createMock(RequestInterface::class)
                    )
                );

            $this->expectException(AsteriskRestInterfaceException::class);
            $restClientExtensionClass->triggerSendRequest(
                '/someResource',
                ['some' => 'queryParameter'],
                ['some' => 'bodyParameter']
            );
        }

        /**
         * @depends testSendRequest
         *
         * @param ResponseInterface $response An ARI response
         */
        public function testResponseToAriModelInstance(ResponseInterface $response): void
        {
            $settings = $this->createMock(Settings::class);
            $guzzleClient = $this->createMock(GuzzleClient::class);
            $dataMappingService = $this->createMock(DataMappingService::class);
            $dataMappingService->method('mapArrayOntoObject')->willReturn(true);

            $restClientExtensionClass = new class (
                $settings,
                $guzzleClient,
                $dataMappingService,
            ) extends AbstractRestClient {
                public function triggerResponseToAriModelInstance(
                    ResponseInterface $response,
                    ModelInterface $modelInterface
                ): void {
                    $this->responseToAriModelInstance(
                        $response,
                        $modelInterface
                    );
                }
            };

            $channel = new Channel();
            $restClientExtensionClass->triggerResponseToAriModelInstance(
                $response,
                $channel
            );

            $this->assertInstanceOf(Channel::class, $channel);
        }

        /**
         * @depends testSendRequest
         *
         * @param ResponseInterface $response An ARI response
         */
        public function testResponseToAriModelInstanceLogsException(
            ResponseInterface $response
        ): void {
            $settings = $this->createMock(Settings::class);
            $guzzleClient = $this->createMock(GuzzleClient::class);
            $dataMappingService = $this->createMock(DataMappingService::class);
            $dataMappingService->method('mapArrayOntoObject')->willThrowException(
                new InvalidArgumentException()
            );
            $logger = $this->createMock(Logger::class);

            $restClientExtensionClass = new class (
                $settings,
                $guzzleClient,
                $dataMappingService,
                $logger
            ) extends AbstractRestClient {
                public function triggerResponseToAriModelInstance(
                    ResponseInterface $response,
                    ModelInterface $modelInterface
                ): void {
                    $this->responseToAriModelInstance(
                        $response,
                        $modelInterface
                    );
                }
            };

            $channel = new Channel();

            $restClientExtensionClass->triggerResponseToAriModelInstance(
                $response,
                $channel
            );

            $this->assertTrue(true);
        }

        public function testResponseToArrayOfAriModelInstances(): void
        {
            $settings = $this->createMock(Settings::class);
            $guzzleClient = $this->createMock(GuzzleClient::class);

            $restClientExtensionClass = new class (
                $settings,
                $guzzleClient
            ) extends AbstractRestClient
            {
                public function triggerResponseToArrayOfAriModelInstances(
                    ResponseInterface $response,
                    ModelInterface $ariModelInterface,
                    array &$resultArray
                ): void {
                    $this->responseToArrayOfAriModelInstances(
                        $response,
                        $ariModelInterface,
                        $resultArray
                    );
                }
            };

            $streamInterface = $this->createMock(StreamInterface::class);
            $streamInterface
                ->method('__toString')
                ->willReturn(
                    '['
                    . '{'
                    . '"timestamp":"123","ping":"pong","asterisk_id":"id1"'
                    . '},'
                    . '{'
                    . '"timestamp":"1234","ping":"pong","asterisk_id":"id2"'
                    . '}'
                    . ']'
                );

            $responseInterface = $this->createMock(ResponseInterface::class);
            $responseInterface->method('getBody')->willReturn($streamInterface);

            $pings = [];
            $restClientExtensionClass->triggerResponseToArrayOfAriModelInstances(
                $responseInterface,
                new AsteriskPing(),
                $pings
            );

            /** @var AsteriskPing[] $pings */
            [$ping1, $ping2] = $pings;

            $this->assertEquals('id1', $ping1->getAsteriskId());
            $this->assertEquals('id2', $ping2->getAsteriskId());
        }

        public function testResponseToArrayOfAriModelInstancesLogsException(): void
        {
            $settings = $this->createMock(Settings::class);
            $guzzleClient = $this->createMock(GuzzleClient::class);
            $dataMappingService = $this->createMock(DataMappingService::class);
            $dataMappingService->method('mapArrayOntoObject')->willThrowException(
                new InvalidArgumentException()
            );
            $logger = $this->createMock(Logger::class);

            $restClientExtensionClass = new class (
                $settings,
                $guzzleClient,
                $dataMappingService,
                $logger
            ) extends AbstractRestClient {
                public function triggerResponseToArrayOfAriModelInstances(
                    ResponseInterface $response,
                    ModelInterface $ariModelInterface,
                    array &$resultArray
                ): void {
                    $this->responseToArrayOfAriModelInstances(
                        $response,
                        $ariModelInterface,
                        $resultArray
                    );
                }
            };

            $streamInterface = $this->createMock(StreamInterface::class);
            $streamInterface
                ->method('__toString')
                ->willReturn('[["testDataArrayOfModels":"Jo"]]');

            $responseInterface = $this->createMock(ResponseInterface::class);
            $responseInterface->method('getBody')->willReturn($streamInterface);

            $channels = [];
            $restClientExtensionClass->triggerResponseToArrayOfAriModelInstances(
                $responseInterface,
                new Channel(),
                $channels
            );

            $this->assertTrue(true);
        }

        public function testSendDownloadFileRequest(): void
        {
            $settings = $this->createMock(Settings::class);
            $guzzleClient = $this->createMock(GuzzleClient::class);
            $guzzleClient
                ->method('request')
                ->willReturn($this->createMock(ResponseInterface::class));

            $dataMappingService = $this->createMock(DataMappingService::class);

            $restClientExtensionClass = new class (
                $settings,
                $guzzleClient,
                $dataMappingService
            ) extends AbstractRestClient {
                public function triggerSendDownloadFileRequest(
                    string $resourceUri,
                    string $pathToFile
                ): ResponseInterface {
                    return $this->sendDownloadFileRequest($resourceUri, $pathToFile);
                }
            };

            $response = $restClientExtensionClass->triggerSendDownloadFileRequest(
                '/someResource',
                'someLocationForTheFile'
            );

            $this->assertInstanceOf(ResponseInterface::class, $response);
        }

        public function testSendDownloadFileRequestThrowsAriException(): void
        {
            $settings = $this->createMock(Settings::class);
            $guzzleClient = $this->createMock(GuzzleClient::class);
            $dataMappingService = $this->createMock(DataMappingService::class);

            $restClientExtensionClass = new class (
                $settings,
                $guzzleClient,
                $dataMappingService
            ) extends AbstractRestClient
            {
                public function triggerSendRequest(
                    string $uri,
                    string $location
                ): ResponseInterface {
                    return $this->sendDownloadFileRequest($uri, $location);
                }
            };

            $guzzleClient
                ->method('request')
                ->willThrowException(
                    new ClientException(
                        'Client error',
                        $this->createMock(RequestInterface::class)
                    )
                );

            $this->expectException(AsteriskRestInterfaceException::class);
            $restClientExtensionClass->triggerSendRequest(
                '/someResource',
                'someFileLocation'
            );
        }
    }
}
