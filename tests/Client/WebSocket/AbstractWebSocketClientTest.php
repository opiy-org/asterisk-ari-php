<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Client\WebSocket;

use Monolog\Logger;
use NgVoice\AriClient\Client\Rest\Resource\Applications;
use NgVoice\AriClient\Client\WebSocket\{AbstractWebSocketClient, Settings};
use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use NgVoice\AriClient\Model\Message\Event\ChannelUserevent;
use NgVoice\AriClient\StasisApplicationInterface;
use Oktavlachs\DataMappingService\DataMappingService;
use PHPUnit\Framework\TestCase;
use React\EventLoop\Factory as EventLoopFactory;
use React\EventLoop\LoopInterface;

/**
 * Class AbstractWebSocketClientTest
 *
 * @package NgVoice\AriClient\Tests\WebSocket
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class AbstractWebSocketClientTest extends TestCase
{
    public function testCreate(): void
    {
        $webSocketClientSettings = $this->createMock(Settings::class);
        $myApp = $this->createMock(StasisApplicationInterface::class);
        $ariApplicationsClient = $this->createMock(Applications::class);
        $logger = $this->createMock(Logger::class);
        $dataMappingService = $this->createMock(DataMappingService::class);
        $loop = $this->createMock(LoopInterface::class);

        $this->assertInstanceOf(
            AbstractWebSocketClient::class,
            $this->getAbstractWebSocketClientImpl(
                $webSocketClientSettings,
                $myApp,
                $ariApplicationsClient,
                $logger,
                $dataMappingService,
                $loop
            )
        );

        $this->assertInstanceOf(
            AbstractWebSocketClient::class,
            $this->getAbstractWebSocketClientImpl(
                $webSocketClientSettings,
                $myApp
            )
        );
    }

    public function testGetLoop(): void
    {
        $webSocketClientSettings = $this->createMock(Settings::class);
        $myApp = $this->createMock(StasisApplicationInterface::class);
        $ariApplicationsClient = $this->createMock(Applications::class);
        $logger = $this->createMock(Logger::class);
        $dataMappingService = $this->createMock(DataMappingService::class);
        $loop = $this->createMock(LoopInterface::class);

        $webSocketClient = $this->getAbstractWebSocketClientImpl(
            $webSocketClientSettings,
            $myApp,
            $ariApplicationsClient,
            $logger,
            $dataMappingService,
            $loop
        );

        $this->assertInstanceOf(LoopInterface::class, $webSocketClient->getLoop());
    }

    /**
     * @throws AsteriskRestInterfaceException Will never throw this!
     * It is just an annotation supposed to suppress warnings.
     */
    public function testOnConnectionHandlerLogic(): void
    {
        $webSocketClientSettings = $this->createMock(Settings::class);
        $myApp = new class implements StasisApplicationInterface {
            /**
             * @param ChannelUserevent $channelUserevent
             *
             * @return void
             */
            public function onAriEventChannelUserevent(
                ChannelUserevent $channelUserevent
            ): void {
            }
        };

        $ariApplicationsClient = $this->createMock(Applications::class);
        $logger = $this->createMock(Logger::class);
        $dataMappingService = $this->createMock(DataMappingService::class);
        $loop = $this->createMock(LoopInterface::class);

        $webSocketClient = $this->getAbstractWebSocketClientImpl(
            $webSocketClientSettings,
            $myApp,
            $ariApplicationsClient,
            $logger,
            $dataMappingService,
            $loop
        );

        $webSocketClient->onConnectionHandlerLogic();

        $this->assertTrue(true);
    }

    public function testOnMessageHandlerLogic(): void
    {
        $webSocketClientSettings = $this->createMock(Settings::class);
        $myApp = new class implements StasisApplicationInterface {
            /**
             * @param ChannelUserevent $channelUserevent
             *
             * @return void
             */
            public function onAriEventChannelUserevent(
                ChannelUserevent $channelUserevent
            ): void {
            }
        };

        $ariApplicationsClient = $this->createMock(Applications::class);

        $logger = $this->createMock(Logger::class);

        $dataMappingService = $this->createMock(DataMappingService::class);
        $dataMappingService->method('mapRawJsonOntoObject')->willReturn(true);

        $loop = $this->createMock(LoopInterface::class);

        $webSocketClient = $this->getAbstractWebSocketClientImpl(
            $webSocketClientSettings,
            $myApp,
            $ariApplicationsClient,
            $logger,
            $dataMappingService,
            $loop
        );

        $webSocketClient->onMessageHandlerLogic('{"type":"ChannelUserevent"}');

        $this->assertTrue(true);
    }

    public function testCreateUri(): void
    {
        $webSocketClientSettings = $this->createMock(Settings::class);
        $webSocketClientSettings
            ->method('getHost')
            ->willReturn('local-test-host');
        $webSocketClientSettings->method('getPort')->willReturn(8088);
        $webSocketClientSettings->method('getUser')->willReturn('testUser');
        $webSocketClientSettings->method('getPassword')->willReturn('huhuhu');

        $myApp = $this->createMock(StasisApplicationInterface::class);
        $ariApplicationsClient = $this->createMock(Applications::class);
        $logger = $this->createMock(Logger::class);
        $dataMappingService = $this->createMock(DataMappingService::class);
        $loop = $this->createMock(LoopInterface::class);

        $webSocketClient = $this->getAbstractWebSocketClientImpl(
            $webSocketClientSettings,
            $myApp,
            $ariApplicationsClient,
            $logger,
            $dataMappingService,
            $loop
        );

        $this->assertTrue(
            (bool) preg_match(
                "/^ws:\/\/local-test-host:8088\/events\?"
                . "api_key=testUser:huhuhu&app=.*&subscribeAll=false$/",
                $webSocketClient->triggerCreateUri()
            )
        );
    }

    /**
     * @param Settings $webSocketClientSettings
     * @param StasisApplicationInterface $myApp
     * @param Applications|null $ariApplicationsClient
     * @param Logger|null $logger
     * @param DataMappingService|null $dataMappingService
     * @param LoopInterface|null $loop
     *
     * @return AbstractWebSocketClient
     */
    private function getAbstractWebSocketClientImpl(
        Settings $webSocketClientSettings,
        StasisApplicationInterface $myApp,
        Applications $ariApplicationsClient = null,
        Logger $logger = null,
        DataMappingService $dataMappingService = null,
        LoopInterface $loop = null
    ): AbstractWebSocketClient {
        return new class (
            $webSocketClientSettings,
            $myApp,
            $ariApplicationsClient,
            $logger,
            $dataMappingService,
            $loop
        ) extends AbstractWebSocketClient {
            private $loop;

            private Settings $webSocketClientSettings;

            private bool $subscribeAll = false;

            /**
             *  constructor.
             *
             * @param Settings $webSocketClientSettings
             * @param StasisApplicationInterface $myApp
             * @param Applications|null $ariApplicationsClient
             * @param Logger|null $logger
             * @param DataMappingService|null $dataMappingService
             * @param LoopInterface|null $loop
             */
            public function __construct(
                Settings $webSocketClientSettings,
                StasisApplicationInterface $myApp,
                Applications $ariApplicationsClient = null,
                Logger $logger = null,
                DataMappingService $dataMappingService = null,
                LoopInterface $loop = null
            ) {
                parent::__construct(
                    $webSocketClientSettings,
                    $myApp,
                    $ariApplicationsClient,
                    $logger,
                    $dataMappingService
                );

                if ($loop === null) {
                    $loop = new EventLoopFactory();
                }

                $this->loop = $loop;
                $this->webSocketClientSettings = $webSocketClientSettings;
            }

            /**
             * @return string
             */
            public function triggerCreateUri(): string
            {
                return $this->createUri(
                    $this->webSocketClientSettings,
                    $this->myApp,
                    $this->subscribeAll
                );
            }

            /**
             * Establish the connection to the WebSocket of your Asterisk instance
             * and listen for specific incoming events.
             */
            public function start(): void
            {
            }

            /**
             * Get the event loop.
             *
             * @return LoopInterface
             */
            public function getLoop(): LoopInterface
            {
                return $this->loop;
            }
        };
    }
}
