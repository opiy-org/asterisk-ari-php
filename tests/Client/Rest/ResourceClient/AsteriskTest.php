<?php

/** @copyright 2020 ng-voice GmbH */

namespace OpiyOrg\AriClient\Tests\Client\Rest\ResourceClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use JsonException;
use GuzzleHttp\Psr7\{Request, Response};
use OpiyOrg\AriClient\Client\Rest\Resource\Asterisk;
use OpiyOrg\AriClient\Client\Rest\Settings;
use OpiyOrg\AriClient\Exception\AsteriskRestInterfaceException;
use OpiyOrg\AriClient\Model\{AsteriskInfo, AsteriskPing, ConfigTuple, LogChannel, Module, Variable};
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * Class AsteriskTest
 *
 * @package OpiyOrg\AriClient\Tests\Client\Rest\ResourceClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class AsteriskTest extends TestCase
{
    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testReloadModule(): void
    {
        $asteriskClient = $this->createAsteriskClientWithGuzzleClientStub([]);
        $asteriskClient->reloadModule('SomeModule');
        $this->assertTrue(true, true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testListModules(): void
    {
        $exampleModule = [
            'name' => 'ExampleName',
            'use_count' => 5,
            'support_level' => 'ExampleSupportLevel',
            'status' => 'running',
            'description' => 'Cool module!',
        ];

        $asteriskClient = $this->createAsteriskClientWithGuzzleClientStub(
            [$exampleModule, $exampleModule, $exampleModule]
        );
        $resultList = $asteriskClient->listModules();

        $this->assertIsArray($resultList);
        foreach ($resultList as $resultChannel) {
            $this->assertInstanceOf(Module::class, $resultChannel);
        }
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testGetObject(): void
    {
        $exampleConfigTuple = [
            'attribute' => 'ExampleAttribute',
            'value' => 'ExampleValue',
        ];

        $asteriskClient = $this->createAsteriskClientWithGuzzleClientStub(
            [$exampleConfigTuple, $exampleConfigTuple, $exampleConfigTuple]
        );
        $resultList = $asteriskClient->getObject(
            'SomeConfigClass',
            'SomeObjectType',
            'SomeId'
        );

        $this->assertIsArray($resultList);
        foreach ($resultList as $resultChannel) {
            $this->assertInstanceOf(ConfigTuple::class, $resultChannel);
        }
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testRotateLog(): void
    {
        $asteriskClient = $this->createAsteriskClientWithGuzzleClientStub([]);
        $asteriskClient->rotateLog('SomeLogChannel');
        $this->assertTrue(true, true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testPing(): void
    {
        $asteriskClient = $this->createAsteriskClientWithGuzzleClientStub(
            [
                'timestamp' => '2016-12-20 13:45:28 UTC',
                'ping' => 'pong',
                'asterisk_id' => '12334679672',
            ]
        );
        $this->assertInstanceOf(AsteriskPing::class, $asteriskClient->ping());
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testGetModule(): void
    {
        $asteriskClient = $this->createAsteriskClientWithGuzzleClientStub(
            [
                'name' => 'ExampleName',
                'use_count' => 5,
                'support_level' => 'ExampleSupportLevel',
                'status' => 'running',
                'description' => 'Cool module!',
            ]
        );
        $this->assertInstanceOf(Module::class, $asteriskClient->getModule('SomeModule'));
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testAddLog(): void
    {
        $asteriskClient = $this->createAsteriskClientWithGuzzleClientStub([]);
        $asteriskClient->addLog('SomeLogChannel', 'SomeConfig');
        $this->assertTrue(true, true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     * @throws JsonException
     */
    public function testGetGlobalVar(): void
    {
        $asteriskClient = $this->createAsteriskClientWithGuzzleClientStub(
            [
                'value' => 'testValue',
            ]
        );
        $this->assertInstanceOf(Variable::class, $asteriskClient->getGlobalVar('SomeVar'));
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testUpdateObject(): void
    {
        $exampleConfigTuple = [
            'attribute' => 'ExampleAttribute',
            'value' => 'ExampleValue',
        ];

        $asteriskClient = $this->createAsteriskClientWithGuzzleClientStub(
            [$exampleConfigTuple, $exampleConfigTuple, $exampleConfigTuple]
        );
        $resultList = $asteriskClient->updateObject(
            'SomeConfigClass',
            'SomeObjectType',
            'SomeId',
            ['SomeAttribute' => 'SomeValue', 'SomeAttribute1' => 'SomeValue1', 'SomeAttribute2' => 'SomeValue2']
        );

        $this->assertIsArray($resultList);
        foreach ($resultList as $resultChannel) {
            $this->assertInstanceOf(ConfigTuple::class, $resultChannel);
        }
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testGetInfo(): void
    {
        $asteriskClient = $this->createAsteriskClientWithGuzzleClientStub(
            [
                'build' => [
                    'os' => 'Linux',
                    'kernel' => '4.9.0-7-amd64',
                    'machine' => 'x86_64',
                    'options' => 'OPTIONAL_API',
                    'date' => '2016-12-20 13:45:28 UTC',
                    'user' => 'root',
                ],

                'system' => [
                    'version' => '16.1.0',
                    'entity_id' => '02:42:ac:11:00:01',
                ],

                'status' => [
                    'startup_time' => '2019-02-19T22:43:31.820+0000',
                    'last_reload_time' => '2019-02-19T22:43:31.820+0000',
                ],
            ]
        );
        $this->assertInstanceOf(AsteriskInfo::class, $asteriskClient->getInfo(['status', 'system', 'status']));
    }

    /**
     * @throws ReflectionException
     * @throws AsteriskRestInterfaceException
     */
    public function testListLogChannels(): void
    {
        $exampleLogChannel = [
            'configuration' => '3',
            'type' => 'DEBUG,ERROR',
            'status' => 'enabled',
            'channel' => '/var/log/syslog',
        ];

        $asteriskClient = $this->createAsteriskClientWithGuzzleClientStub(
            [$exampleLogChannel, $exampleLogChannel, $exampleLogChannel]
        );
        $resultList = $asteriskClient->listLogChannels();

        $this->assertIsArray($resultList);
        foreach ($resultList as $resultLogChannel) {
            $this->assertInstanceOf(LogChannel::class, $resultLogChannel);
        }
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testDeleteLog(): void
    {
        $asteriskClient = $this->createAsteriskClientWithGuzzleClientStub([]);
        $asteriskClient->deleteLog('SomeLogChannel');
        $this->assertTrue(true, true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testSetGlobalVar(): void
    {
        $asteriskClient = $this->createAsteriskClientWithGuzzleClientStub([]);
        $asteriskClient->setGlobalVar('SomeVar', 'SomeVal');
        $this->assertTrue(true, true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testUnloadModule(): void
    {
        $asteriskClient = $this->createAsteriskClientWithGuzzleClientStub([]);
        $asteriskClient->unloadModule('SomeModule');
        $this->assertTrue(true, true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testLoadModule(): void
    {
        $asteriskClient = $this->createAsteriskClientWithGuzzleClientStub([]);
        $asteriskClient->loadModule('SomeModule');
        $this->assertTrue(true, true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testDeleteObject(): void
    {
        $asteriskClient = $this->createAsteriskClientWithGuzzleClientStub([]);
        $asteriskClient->deleteObject('SomeChannelId', 'SomeObject', 'SomeId');
        $this->assertTrue(true, true);
    }

    /**
     * @param $expectedResponse
     * @return Asterisk
     * @throws ReflectionException
     */
    private function createAsteriskClientWithGuzzleClientStub($expectedResponse): Asterisk
    {
        $guzzleClientStub = $this->createMock(Client::class);
        $guzzleClientStub->method('request')
            // TODO: Test for correct parameter translation via with() method here?
            //  ->with()
            ->willReturn(
                new Response(
                    200,
                    [],
                    json_encode($expectedResponse),
                    '1.1',
                    'SomeReason'
                )
            );

        /**
         * @var Client $guzzleClientStub
         */
        return new Asterisk(
            new Settings('SomeUser', 'SomePw'),
            $guzzleClientStub
        );
    }

    /**
     * @return Asterisk
     * @throws ReflectionException
     */
    private function createAsteriskClientThatThrowsException(): Asterisk
    {
        $guzzleClientStub = $this->createMock(Client::class);
        $guzzleClientStub->method('request')
            // TODO: Test for correct parameter translation via with() method here?
            //  ->with()
            ->willThrowException(
                new ServerException(
                    'Internal Server Error',
                    new Request('PUT', '/asterisk/test'),
                    new Response(),
                )
            );

        /**
         * @var Client $guzzleClientStub
         */
        return new Asterisk(
            new Settings('SomeUser', 'SomePw'),
            $guzzleClientStub
        );
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testPutRequestException(): void
    {
        $asteriskClient = $this->createAsteriskClientThatThrowsException();
        $this->expectException(AsteriskRestInterfaceException::class);
        $asteriskClient->updateObject(
            'SomeConfigClass',
            'SomeObjectType',
            'SomeId',
            ['SomeAttribute' => 'SomeValue', 'SomeAttribute1' => 'SomeValue1', 'SomeAttribute2' => 'SomeValue2']
        );
    }
}
