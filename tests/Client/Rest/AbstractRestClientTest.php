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
    use NgVoice\AriClient\Client\Rest\{AbstractRestClient, Settings};
    use NgVoice\AriClient\Enum\HttpMethods;
    use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
    use NgVoice\AriClient\Model\{AsteriskPing, Channel, ModelInterface};
    use NgVoice\AriClient\Tests\Model\ChannelTest;
    use PHPUnit\Framework\MockObject\MockObject;
    use PHPUnit\Framework\TestCase;
    use Psr\Http\Message\RequestInterface;
    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\StreamInterface;
    use Psr\Log\LoggerInterface;

    /**
     * Class AbstractRestClientTest
     *
     * @package NgVoice\AriClient\Tests\Rest
     *
     * @author Ahmad Hussain <ahmad@ng-voice.com>
     */
    class AbstractRestClientTest extends TestCase
    {
        /**
         * @var AbstractRestClient|MockObject
         */
        private $abstractRestClient;

        /**
         * @var GuzzleClient|MockObject
         */
        private $httpClient;

        private Settings $settings;

        /**
         * @var MockObject|LoggerInterface
         */
        private $loggerInterface;

        public function setUp(): void
        {
            $this->loggerInterface = $this->createMock(LoggerInterface::class);
            $this->settings = new Settings('asterisk', 'asterisk');
            $this->settings->setLoggerInterface($this->loggerInterface);
            $this->settings->setIsInDebugMode(true);
            $this->httpClient = $this->createMock(GuzzleClient::class);

            $this->abstractRestClient = new class (
                $this->settings,
                $this->httpClient
            ) extends AbstractRestClient {
                public function triggerSendRequest(string $resourceUri, array $queryParameters, array $body): ResponseInterface
                {
                    return $this->sendRequest(HttpMethods::GET, $resourceUri, $queryParameters, $body);
                }
            };
        }

        public function testCreate(): void
        {
            $this->assertInstanceOf(
                AbstractRestClient::class,
                $this->abstractRestClient
            );

            $this->assertInstanceOf(
                AbstractRestClient::class,
                new class ($this->settings) extends AbstractRestClient {}
            );
        }

        public function testSendRequest(): void
        {
            $streamInterface = $this->createMock(StreamInterface::class);
            $streamInterface
                ->method('__toString')
                ->willReturn('{"dummyDataTestSendRequest":"Jo"}');
            $responseInterface = $this->createMock(ResponseInterface::class);
            $responseInterface->method('getBody')->willReturn($streamInterface);
            $this->httpClient->method('request')->willReturn($responseInterface);

            $response = $this->abstractRestClient->triggerSendRequest(
                '/someResource',
                ['some' => 'queryParameter'],
                ['some' => 'bodyParameter']
            );

            /** @noinspection PhpUndefinedMethodInspection */
            $this->assertSame(
                '{"dummyDataTestSendRequest":"Jo"}',
                (string) $response->getBody()
            );
        }

        public function testSendRequestThrowsAriException(): void
        {
            $restClientExtensionClass = new class (
                $this->settings,
                $this->httpClient,
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

            $this->httpClient
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

        public function testResponseToAriModelInstance(): void
        {
            $settings = new Settings('asterisk', 'asterisk');
            $settings->setLoggerInterface($this->createMock(LoggerInterface::class));
            $guzzleClient = $this->createMock(GuzzleClient::class);

            $restClientExtensionClass = new class (
                $settings,
                $guzzleClient
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

            $streamInterface = $this->createMock(StreamInterface::class);
            $streamInterface
                ->method('__toString')
                ->willReturn(
                    json_encode(
                        ChannelTest::RAW_ARRAY_REPRESENTATION,
                        JSON_THROW_ON_ERROR
                    )
                );
            $responseInterface = $this->createMock(ResponseInterface::class);
            $responseInterface->method('getBody')->willReturn($streamInterface);

            $channel = new Channel();

            $restClientExtensionClass
                ->triggerResponseToAriModelInstance($responseInterface, $channel);

            $this->assertSame('123456', $channel->getId());
        }

        public function testResponseToAriModelInstanceLogsException(): void
        {
            $settings = new Settings('asterisk', 'asterisk');
            $settings->setLoggerInterface($this->createMock(LoggerInterface::class));
            $guzzleClient = $this->createMock(GuzzleClient::class);

            $restClientExtensionClass = new class (
                $settings,
                $guzzleClient
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

            $streamInterface = $this->createMock(StreamInterface::class);
            $streamInterface
                ->method('__toString')
                ->willReturn(json_encode(['jo' => 'moin'], JSON_THROW_ON_ERROR));
            $responseInterface = $this->createMock(ResponseInterface::class);
            $responseInterface->method('getBody')->willReturn($streamInterface);

            $channel = new Channel();

            $this->expectException(AsteriskRestInterfaceException::class);
            $restClientExtensionClass
                ->triggerResponseToAriModelInstance($responseInterface, $channel);
        }

        public function testResponseToArrayOfAriModelInstances(): void
        {
            $restClientExtensionClass = new class (
                $this->settings,
                $this->httpClient
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
            $restClientExtensionClass = new class (
                $this->settings,
                $this->httpClient
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
            $this->expectException(AsteriskRestInterfaceException::class);
            $restClientExtensionClass->triggerResponseToArrayOfAriModelInstances(
                $responseInterface,
                new Channel(),
                $channels
            );
        }

        public function testSendDownloadFileRequest(): void
        {
            $this->httpClient
                ->method('request')
                ->willReturn($this->createMock(ResponseInterface::class));

            $restClientExtensionClass = new class (
                $this->settings,
                $this->httpClient,
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

            $restClientExtensionClass = new class (
                $settings,
                $guzzleClient,
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
