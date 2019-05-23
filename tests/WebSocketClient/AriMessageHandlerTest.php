<?php

/**
 * @copyright 2019 ng-voice GmbH
 * @author Lukas Stermann <lukas@ng-voice.com>
 */

namespace NgVoice\AriClient\Tests\WebSocketClient;

use ExampleApp;
use JsonMapper;
use Nekland\Woketo\Core\AbstractConnection;
use Nekland\Woketo\Exception\WebsocketException;
use NgVoice\AriClient\AsteriskStasisApplication;
use NgVoice\AriClient\Models\Message\MissingParams;
use NgVoice\AriClient\WebSocketClient\AriMessageHandler;
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * Class AriMessageHandlerTest
 *
 * @package NgVoice\AriClient\Tests\WebSocketClient
 */
class AriMessageHandlerTest extends TestCase
{
    /**
     * @return array
     * @throws ReflectionException
     */
    public function localAppMessageHandlerStubProvider(): array
    {
        $basicStasisAppStub = $this->createMock(AsteriskStasisApplication::class);
        /**
         * @var AsteriskStasisApplication $basicStasisAppStub
         */
        return [
            'setup local message handler' =>
                [$basicStasisAppStub]
        ];
    }

    /**
     * @dataProvider localAppMessageHandlerStubProvider
     * @param AsteriskStasisApplication $basicStasisAppStub
     */
    public function test__construct(AsteriskStasisApplication $basicStasisAppStub): void
    {
        $this->assertInstanceOf(
            AriMessageHandler::class,
            new AriMessageHandler($basicStasisAppStub)
        );
    }

    /**
     * @dataProvider localAppMessageHandlerStubProvider
     * @param AsteriskStasisApplication $basicStasisAppStub
     * @throws ReflectionException
     */
    public function testOnConnection(AsteriskStasisApplication $basicStasisAppStub): void
    {
        $localAppMessageHandler = new AriMessageHandler($basicStasisAppStub);

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
         * @var AsteriskStasisApplication $basicStasisAppStub
         */

        $jsonMapperStub = $this->createMock(JsonMapper::class);
        $jsonMapperStub->method('map')->willReturn(new MissingParams());
        /**
         * @var JsonMapper $jsonMapperStub
         */
        $localAppMessageHandler =
            new AriMessageHandler($basicStasisAppStub, $jsonMapperStub);
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
     * @param AsteriskStasisApplication $basicStasisAppStub
     * @throws ReflectionException
     */
    public function testOnDisconnect(AsteriskStasisApplication $basicStasisAppStub): void
    {
        $localAppMessageHandler = new AriMessageHandler($basicStasisAppStub);

        $abstractConnectionStub = $this->createMock(AbstractConnection::class);

        /**
         * @var AbstractConnection $abstractConnectionStub
         */
        $localAppMessageHandler->onDisconnect($abstractConnectionStub);
        $this->assertTrue(true, true);
    }

    /**
     * @dataProvider localAppMessageHandlerStubProvider
     * @param AsteriskStasisApplication $basicStasisAppStub
     * @throws ReflectionException
     * @throws WebsocketException
     */
    public function testOnError(AsteriskStasisApplication $basicStasisAppStub): void
    {
        $localAppMessageHandler = new AriMessageHandler($basicStasisAppStub);

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
