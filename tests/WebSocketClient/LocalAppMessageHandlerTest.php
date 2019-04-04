<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2019)
 */

namespace NgVoice\AriClient\Tests\WebSocketClient;

use ExampleApp;
use JsonMapper;
use Nekland\Woketo\Core\AbstractConnection;
use Nekland\Woketo\Exception\WebsocketException;
use NgVoice\AriClient\BasicStasisApp;
use NgVoice\AriClient\Model\Message\MissingParams;
use NgVoice\AriClient\WebSocketClient\LocalAppMessageHandler;
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * Class LocalAppMessageHandlerTest
 * @package NgVoice\AriClient\Tests\WebSocketClient
 */
class LocalAppMessageHandlerTest extends TestCase
{
    /**
     * @return array
     * @throws ReflectionException
     */
    public function localAppMessageHandlerStubProvider(): array
    {
        $basicStasisAppStub = $this->createMock(BasicStasisApp::class);
        /**
         * @var BasicStasisApp $basicStasisAppStub
         */
        return [
            'setup local message handler' =>
                [$basicStasisAppStub]
        ];
    }

    /**
     * @dataProvider localAppMessageHandlerStubProvider
     * @param BasicStasisApp $basicStasisAppStub
     */
    public function test__construct(BasicStasisApp $basicStasisAppStub): void
    {
        $this->assertInstanceOf(
            LocalAppMessageHandler::class,
            new LocalAppMessageHandler($basicStasisAppStub)
        );
    }

    /**
     * @dataProvider localAppMessageHandlerStubProvider
     * @param BasicStasisApp $basicStasisAppStub
     * @throws ReflectionException
     */
    public function testOnConnection(BasicStasisApp $basicStasisAppStub): void
    {
        $localAppMessageHandler = new LocalAppMessageHandler($basicStasisAppStub);

        $abstractConnectionStub = $this->createMock(AbstractConnection::class);

        /**
         * @var AbstractConnection $abstractConnectionStub
         */
        $localAppMessageHandler->onConnection($abstractConnectionStub);
        $this->assertTrue(true, true);
    }

    /**
     * @throws ReflectionException
     */
    public function testOnMessage(): void
    {
        require_once __DIR__ . '/../../examples/ExampleApp.php';
        $basicStasisAppStub = $this->createMock(ExampleApp::class);
        $basicStasisAppStub->method('channelUserevent');

        /**
         * @var BasicStasisApp $basicStasisAppStub
         */

        $jsonMapperStub = $this->createMock(JsonMapper::class);
        $jsonMapperStub->method('map')->willReturn(new MissingParams());
        /**
         * @var JsonMapper $jsonMapperStub
         */
        $localAppMessageHandler = new LocalAppMessageHandler($basicStasisAppStub, $jsonMapperStub);
        $abstractConnectionStub = $this->createMock(AbstractConnection::class);

        /**
         * @var AbstractConnection $abstractConnectionStub
         */
        $localAppMessageHandler->onMessage(
            json_encode(['asterisk_id' => '12345', 'type' => 'MissingParams', ['param1', 'param2']]),
            $abstractConnectionStub
        );
        $this->assertTrue(true, true);
    }

    /**
     * @dataProvider localAppMessageHandlerStubProvider
     * @param BasicStasisApp $basicStasisAppStub
     * @throws ReflectionException
     */
    public function testOnDisconnect(BasicStasisApp $basicStasisAppStub): void
    {
        $localAppMessageHandler = new LocalAppMessageHandler($basicStasisAppStub);

        $abstractConnectionStub = $this->createMock(AbstractConnection::class);

        /**
         * @var AbstractConnection $abstractConnectionStub
         */
        $localAppMessageHandler->onDisconnect($abstractConnectionStub);
        $this->assertTrue(true, true);
    }

    /**
     * @dataProvider localAppMessageHandlerStubProvider
     * @param BasicStasisApp $basicStasisAppStub
     * @throws ReflectionException
     * @throws WebsocketException
     */
    public function testOnError(BasicStasisApp $basicStasisAppStub): void
    {
        $localAppMessageHandler = new LocalAppMessageHandler($basicStasisAppStub);

        $abstractConnectionStub = $this->createMock(AbstractConnection::class);
        $webSocketException = $this->createMock(WebsocketException::class);

        /**
         * @var AbstractConnection $abstractConnectionStub
         * @var WebsocketException $webSocketException
         */
        $this->expectException(WebsocketException::class);
        $localAppMessageHandler->onError($webSocketException, $abstractConnectionStub);
    }
}