<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2019)
 */

namespace AriStasisApp\Tests\websocket_client;

use AriStasisApp\BasicStasisApp;
use AriStasisApp\models\messages\MissingParams;
use AriStasisApp\websocket_client\LocalAppMessageHandler;
use JsonMapper;
use Nekland\Woketo\Core\AbstractConnection;
use Nekland\Woketo\Exception\WebsocketException;
use PHPUnit\Framework\TestCase;

/**
 * Class LocalAppMessageHandlerTest
 * @package AriStasisApp\Tests\websocket_client
 */
class LocalAppMessageHandlerTest extends TestCase
{
    /**
     * @return array
     * @throws \ReflectionException
     */
    public function localAppMessageHandlerStubProvider()
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
    public function test__construct(BasicStasisApp $basicStasisAppStub)
    {
        $this->assertInstanceOf(
            LocalAppMessageHandler::class,
            new LocalAppMessageHandler($basicStasisAppStub)
        );
    }

    /**
     * @dataProvider localAppMessageHandlerStubProvider
     * @param BasicStasisApp $basicStasisAppStub
     * @throws \ReflectionException
     */
    public function testOnConnection(BasicStasisApp $basicStasisAppStub)
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
     * @dataProvider localAppMessageHandlerStubProvider
     * @param BasicStasisApp $basicStasisAppStub
     * @throws \ReflectionException
     */
    public function testOnMessage(BasicStasisApp $basicStasisAppStub)
    {
        $jsonMapperStub = $this->createMock(JsonMapper::class);
        $jsonMapperStub->method('map')->willReturn(new MissingParams());
        /**
         * @var JsonMapper $jsonMapperStub
         */
        $localAppMessageHandler = new LocalAppMessageHandler($basicStasisAppStub, $jsonMapperStub);
        $abstractConnectionStub = $this->createMock(AbstractConnection::class);

        /*
         * TODO: We expect an error exception here,because we did not mock a fake class that contains
         *  the missingParams() method. We should though in the future.
         */
        $this->expectException(\Error::class);
        /**
         * @var AbstractConnection $abstractConnectionStub
         */
        $localAppMessageHandler->onMessage(
            json_encode(['asterisk_id' => '12345', 'type' => 'MissingParams', ['param1', 'param2']]),
            $abstractConnectionStub
        );
    }

    /**
     * @dataProvider localAppMessageHandlerStubProvider
     * @param BasicStasisApp $basicStasisAppStub
     * @throws \ReflectionException
     */
    public function testOnDisconnect(BasicStasisApp $basicStasisAppStub)
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
     * @throws \ReflectionException
     * @throws \Nekland\Woketo\Exception\WebsocketException
     */
    public function testOnError(BasicStasisApp $basicStasisAppStub)
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

    /**
     * @dataProvider localAppMessageHandlerStubProvider
     * @param BasicStasisApp $basicStasisAppStub
     * @throws \ReflectionException
     */
    public function testJSONMapperThrowsException(BasicStasisApp $basicStasisAppStub)
    {
        $jsonMapperStub = $this->createMock(\JsonMapper::class);
        $jsonMapperStub->method('map')->willThrowException(new \JsonMapper_Exception('Test exception'));
        /**
         * @var \JsonMapper $jsonMapperStub
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
}