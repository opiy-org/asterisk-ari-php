<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Client\Rest {

    use GuzzleHttp\Client as GuzzleClient;
    use GuzzleHttp\Exception\ClientException;
    use GuzzleHttp\Psr7\Response;
    use OpiyOrg\AriClient\Client\Rest\{AbstractRestClient, Settings};
    use OpiyOrg\AriClient\Enum\HttpMethods;
    use OpiyOrg\AriClient\Exception\AsteriskRestInterfaceException;
    use OpiyOrg\AriClient\Model\{AsteriskPing, Channel, ModelInterface};
    use OpiyOrg\AriClient\Tests\Model\ChannelTest;
    use PHPUnit\Framework\MockObject\MockObject;
    use PHPUnit\Framework\TestCase;
    use Psr\Http\Message\RequestInterface;
    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\StreamInterface;
    use Psr\Log\LoggerInterface;

    /**
     * Class AbstractRestClientTest
     *
     * @package OpiyOrg\AriClient\Tests\Rest
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
                public function triggerSendRequest(
                    string $resourceUri,
                    array $queryParameters,
                    array $body
                ): ResponseInterface {
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
                new class ($this->settings) extends AbstractRestClient {
                }
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

            $this->assertSame(
                '{"dummyDataTestSendRequest":"Jo"}',
                (string)$response->getBody()
            );
        }

        public function testSendRequestThrowsAriException(): void
        {
            $restClientExtensionClass = new class (
                $this->settings,
                $this->httpClient,
            ) extends AbstractRestClient {
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
                        $this->createMock(RequestInterface::class),
                        new Response(),
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
                    ModelInterface &$modelInterface
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
                ->willReturn('[{"testDataArrayOfModels":"Jo"}]');

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
            ) extends AbstractRestClient {
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
                        $this->createMock(RequestInterface::class),
                        new Response(),
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
