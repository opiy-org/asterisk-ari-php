<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\RestClient {

    use NgVoice\AriClient\Models\Channel;
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
        } elseif ($json === 'dummyDataTestSendRequest') {
            return new stdClass();
        }

        return \json_decode($json, $assoc, 512, JSON_THROW_ON_ERROR);
    }
}

namespace NgVoice\AriClient\Tests\RestClient {

    use GuzzleHttp\Client as GuzzleClient;
    use GuzzleHttp\Exception\ClientException;
    use JsonMapper;
    use JsonMapper_Exception;
    use NgVoice\AriClient\Collection\HttpMethods;
    use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
    use NgVoice\AriClient\Models\{Channel, ModelInterface};
    use NgVoice\AriClient\RestClient\{AbstractRestClient, Settings};
    use PHPUnit\Framework\TestCase;
    use Psr\Http\Message\RequestInterface;
    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\StreamInterface;

    /**
     * Class AbstractRestClientTest
     *
     * @package NgVoice\AriClient\Tests\RestClient
     *
     * @author Ahmad Hussain <ahmad@ng-voice.com>
     */
    class AbstractRestClientTest extends TestCase
    {
        public function testCreate(): void
        {
            $settings = $this->createMock(Settings::class);
            $guzzleClient = $this->createMock(GuzzleClient::class);
            $jsonMapper = $this->createMock(JsonMapper::class);

            $this->assertInstanceOf(
                AbstractRestClient::class,
                $this->getMockForAbstractClass(
                    AbstractRestClient::class,
                    [$settings, $guzzleClient, $jsonMapper]
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
            $jsonMapper = $this->createMock(JsonMapper::class);

            $restClientExtensionClass = new class (
                $settings,
                $guzzleClient,
                $jsonMapper
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
                ->willReturn('dummyDataTestSendRequest');

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

            $this->assertInstanceOf(
                ResponseInterface::class,
                $response
            );

            return $response;
        }

        public function testSendRequestThrowsAriException(): void
        {
            $settings = $this->createMock(Settings::class);
            $guzzleClient = $this->createMock(GuzzleClient::class);
            $jsonMapper = $this->createMock(JsonMapper::class);

            $restClientExtensionClass = new class (
                $settings,
                $guzzleClient,
                $jsonMapper
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
            $jsonMapper = $this->createMock(JsonMapper::class);
            $jsonMapper->method('map')->willReturn(new Channel());

            $restClientExtensionClass = new class (
                $settings,
                $guzzleClient,
                $jsonMapper
            ) extends AbstractRestClient
            {
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
        public function testResponseToAriModelInstanceThrowsException(
            ResponseInterface $response
        ): void {
            $settings = $this->createMock(Settings::class);
            $guzzleClient = $this->createMock(GuzzleClient::class);
            $jsonMapper = $this->createMock(JsonMapper::class);
            $jsonMapper->method('map')->willThrowException(
                new JsonMapper_Exception()
            );

            $restClientExtensionClass = new class (
                $settings,
                $guzzleClient,
                $jsonMapper
            ) extends AbstractRestClient
            {
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
            $this->expectException(AsteriskRestInterfaceException::class);
            $restClientExtensionClass->triggerResponseToAriModelInstance(
                $response,
                $channel
            );

            $this->assertInstanceOf(Channel::class, $channel);
        }

        public function testResponseToArrayOfAriModelInstances(): void
        {
            $settings = $this->createMock(Settings::class);
            $guzzleClient = $this->createMock(GuzzleClient::class);
            $jsonMapper = $this->createMock(JsonMapper::class);
            $jsonMapper->method('map')->willReturn(new Channel());

            $restClientExtensionClass = new class (
                $settings,
                $guzzleClient,
                $jsonMapper
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
                ->willReturn('testDataArrayOfModels');

            $responseInterface = $this->createMock(ResponseInterface::class);
            $responseInterface->method('getBody')->willReturn($streamInterface);

            /** @var Channel[] $channels */
            $channels = [];
            $restClientExtensionClass->triggerResponseToArrayOfAriModelInstances(
                $responseInterface,
                new Channel(),
                $channels
            );

            foreach ($channels as $channel) {
                $this->assertInstanceOf(Channel::class, $channel);
            }
        }

        public function testResponseToArrayOfAriModelInstancesThrowsException(): void
        {
            $settings = $this->createMock(Settings::class);
            $guzzleClient = $this->createMock(GuzzleClient::class);
            $jsonMapper = $this->createMock(JsonMapper::class);
            $jsonMapper->method('map')->willThrowException(
                new JsonMapper_Exception()
            );

            $restClientExtensionClass = new class (
                $settings,
                $guzzleClient,
                $jsonMapper
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
                ->willReturn('testDataArrayOfModels');

            $responseInterface = $this->createMock(ResponseInterface::class);
            $responseInterface->method('getBody')->willReturn($streamInterface);

            /** @var Channel[] $channels */
            $channels = [];
            $this->expectException(AsteriskRestInterfaceException::class);
            $restClientExtensionClass->triggerResponseToArrayOfAriModelInstances(
                $responseInterface,
                new Channel(),
                $channels
            );
        }

        public function testSendDownloadFileRequest(): void
        {
            $settings = $this->createMock(Settings::class);

            $guzzleClient = $this->createMock(GuzzleClient::class);

            $jsonMapper = $this->createMock(JsonMapper::class);

            $restClientExtensionClass = new class (
                $settings,
                $guzzleClient,
                $jsonMapper
            ) extends AbstractRestClient
            {
                public function triggerSendDownloadFileRequest(
                    string $resourceUri,
                    string $pathToFile
                ): void {
                    $this->sendDownloadFileRequest($resourceUri, $pathToFile);
                }
            };

            $restClientExtensionClass->triggerSendDownloadFileRequest(
                '/someResource',
                'someLocationForTheFile'
            );

            $this->assertTrue(true);
        }

        public function testSendDownloadFileRequestThrowsAriException(): void
        {
            $settings = $this->createMock(Settings::class);
            $guzzleClient = $this->createMock(GuzzleClient::class);
            $jsonMapper = $this->createMock(JsonMapper::class);

            $restClientExtensionClass = new class (
                $settings,
                $guzzleClient,
                $jsonMapper
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
