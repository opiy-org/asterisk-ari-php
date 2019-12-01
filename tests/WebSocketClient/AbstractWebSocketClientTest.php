<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\WebSocketClient;

use JsonMapper;
use Monolog\Logger;
use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use NgVoice\AriClient\Models\Message\ChannelUserevent;
use NgVoice\AriClient\RestClient\ResourceClient\Applications;
use NgVoice\AriClient\StasisApplicationInterface;
use NgVoice\AriClient\WebSocketClient\{AbstractWebSocketClient, Settings};
use PHPUnit\Framework\TestCase;
use React\EventLoop\Factory as EventLoopFactory;
use React\EventLoop\LoopInterface;

/**
 * Class AbstractWebSocketClientTest
 *
 * @package NgVoice\AriClient\Tests\WebSocketClient
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
        $jsonMapper = $this->createMock(JsonMapper::class);
        $loop = $this->createMock(LoopInterface::class);

        $this->assertInstanceOf(
            AbstractWebSocketClient::class,
            $this->getAbstractWebSocketClientImpl(
                $webSocketClientSettings,
                $myApp,
                $ariApplicationsClient,
                $logger,
                $jsonMapper,
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
        $jsonMapper = $this->createMock(JsonMapper::class);
        $loop = $this->createMock(LoopInterface::class);

        $webSocketClient = $this->getAbstractWebSocketClientImpl(
            $webSocketClientSettings,
            $myApp,
            $ariApplicationsClient,
            $logger,
            $jsonMapper,
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
        $myApp = new class implements StasisApplicationInterface
        {
            public function onAriEventChannelUserevent(
                ChannelUserevent $channelUserevent
            ): void {
                return;
            }
        };

        $ariApplicationsClient = $this->createMock(Applications::class);
        $logger = $this->createMock(Logger::class);
        $jsonMapper = $this->createMock(JsonMapper::class);
        $loop = $this->createMock(LoopInterface::class);

        $webSocketClient = $this->getAbstractWebSocketClientImpl(
            $webSocketClientSettings,
            $myApp,
            $ariApplicationsClient,
            $logger,
            $jsonMapper,
            $loop
        );

        $webSocketClient->onConnectionHandlerLogic();

        $this->assertTrue(true);
    }

    public function testOnMessageHandlerLogic(): void
    {
        $webSocketClientSettings = $this->createMock(Settings::class);
        $myApp = new class implements StasisApplicationInterface
        {
            public function onAriEventChannelUserevent(
                ChannelUserevent $channelUserevent
            ): void {
                return;
            }
        };

        $ariApplicationsClient = $this->createMock(Applications::class);

        $logger = $this->createMock(Logger::class);

        $channelUserEvent = $this->createMock(ChannelUserevent::class);

        $jsonMapper = $this->createMock(JsonMapper::class);
        $jsonMapper->method('map')->willReturn($channelUserEvent);

        $loop = $this->createMock(LoopInterface::class);

        $webSocketClient = $this->getAbstractWebSocketClientImpl(
            $webSocketClientSettings,
            $myApp,
            $ariApplicationsClient,
            $logger,
            $jsonMapper,
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
        $jsonMapper = $this->createMock(JsonMapper::class);
        $loop = $this->createMock(LoopInterface::class);

        $webSocketClient = $this->getAbstractWebSocketClientImpl(
            $webSocketClientSettings,
            $myApp,
            $ariApplicationsClient,
            $logger,
            $jsonMapper,
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

    private function getAbstractWebSocketClientImpl(
        Settings $webSocketClientSettings,
        StasisApplicationInterface $myApp,
        Applications $ariApplicationsClient = null,
        Logger $logger = null,
        JsonMapper $jsonMapper = null,
        LoopInterface $loop = null
    ): AbstractWebSocketClient {
        return new class (
            $webSocketClientSettings,
            $myApp,
            $ariApplicationsClient,
            $logger,
            $jsonMapper,
            $loop
        ) extends AbstractWebSocketClient
        {
            private $loop;

            /**
             * @var Settings
             */
            private $webSocketClientSettings;

            /**
             * @var bool
             */
            private $subscribeAll = false;

            public function __construct(
                Settings $webSocketClientSettings,
                StasisApplicationInterface $myApp,
                Applications $ariApplicationsClient = null,
                Logger $logger = null,
                JsonMapper $jsonMapper = null,
                LoopInterface $loop = null
            ) {
                parent::__construct(
                    $webSocketClientSettings,
                    $myApp,
                    $ariApplicationsClient,
                    $logger,
                    $jsonMapper
                );

                if ($loop === null) {
                    $loop = new EventLoopFactory();
                }

                $this->loop = $loop;
                $this->webSocketClientSettings = $webSocketClientSettings;
            }

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
                return;
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
