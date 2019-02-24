<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2019)
 */

namespace AriStasisApp\Tests\rest_clients;

use AriStasisApp\models\{AsteriskInfo, AsteriskPing, ConfigTuple, LogChannel, Module, Variable};
use AriStasisApp\rest_clients\Asterisk;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class AsteriskTest extends TestCase
{

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testReloadModule()
    {
        $asteriskClient = $this->createAsteriskClientWithGuzzleClientStub([]);
        $asteriskClient->reloadModule('SomeModule');
        $this->assertTrue(true, true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testListModules()
    {
        $exampleModule = [
            'name' => 'ExampleName',
            'use_count' => '5',
            'support_level' => 'ExampleSupportLevel',
            'status' => 'running',
            'description' => 'Cool module!'
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testGetObject()
    {
        $exampleConfigTuple = [
            'attribute' => 'ExampleAttribute',
            'value' => 'ExampleValue'
        ];

        $asteriskClient = $this->createAsteriskClientWithGuzzleClientStub(
            [$exampleConfigTuple, $exampleConfigTuple, $exampleConfigTuple]
        );
        $resultList = $asteriskClient->getObject('SomeConfigClass', 'SomeObjectType', 'SomeId');

        $this->assertIsArray($resultList);
        foreach ($resultList as $resultChannel) {
            $this->assertInstanceOf(ConfigTuple::class, $resultChannel);
        }
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testRotateLog()
    {
        $asteriskClient = $this->createAsteriskClientWithGuzzleClientStub([]);
        $asteriskClient->rotateLog('SomeLogChannel');
        $this->assertTrue(true, true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testPing()
    {
        $asteriskClient = $this->createAsteriskClientWithGuzzleClientStub(
            [
                'timestamp' => '2016-12-20 13:45:28 UTC',
                'ping' => 'pong',
                'asterisk_id' => '12334679672'
            ]
        );
        $this->assertInstanceOf(AsteriskPing::class, $asteriskClient->ping());
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testGetModule()
    {
        $asteriskClient = $this->createAsteriskClientWithGuzzleClientStub(
            [
                'name' => 'ExampleName',
                'use_count' => '5',
                'support_level' => 'ExampleSupportLevel',
                'status' => 'running',
                'description' => 'Cool module!'
            ]
        );
        $this->assertInstanceOf(Module::class, $asteriskClient->getModule('SomeModule'));
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testAddLog()
    {
        $asteriskClient = $this->createAsteriskClientWithGuzzleClientStub([]);
        $asteriskClient->addLog('SomeLogChannel', 'SomeConfig');
        $this->assertTrue(true, true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testGetGlobalVar()
    {
        $asteriskClient = $this->createAsteriskClientWithGuzzleClientStub(
            [
                'value' => 'testValue'
            ]
        );
        $this->assertInstanceOf(Variable::class, $asteriskClient->getGlobalVar('SomeVar'));
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testUpdateObject()
    {
        $exampleConfigTuple = [
            'attribute' => 'ExampleAttribute',
            'value' => 'ExampleValue'
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testGetInfo()
    {
        $asteriskClient = $this->createAsteriskClientWithGuzzleClientStub(
            [
                'build' => [
                    'os' => 'Linux',
                    'kernel' => '4.9.0-7-amd64',
                    'machine' => 'x86_64',
                    'options' => 'OPTIONAL_API',
                    'date' => '2016-12-20 13:45:28 UTC',
                    'user' => 'root'
                ],

                'system' => [
                    'version' => '16.1.0',
                    'entity_id' => '02:42:ac:11:00:01'
                ],

                'status' => [
                    'startup_time' => '2019-02-19T22:43:31.820+0000',
                    'last_reload_time' => '2019-02-19T22:43:31.820+0000'
                ]
            ]
        );
        $this->assertInstanceOf(AsteriskInfo::class, $asteriskClient->getInfo(['status', 'system', 'status']));
    }

    /**
     * @throws \ReflectionException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testListLogChannels()
    {
        $exampleLogChannel = [
            'configuration' => '3',
            'type' => 'DEBUG,ERROR',
            'status' => 'enabled',
            'channel' => '/var/log/syslog'
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testDeleteLog()
    {
        $asteriskClient = $this->createAsteriskClientWithGuzzleClientStub([]);
        $asteriskClient->deleteLog('SomeLogChannel');
        $this->assertTrue(true, true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testSetGlobalVar()
    {
        $asteriskClient = $this->createAsteriskClientWithGuzzleClientStub([]);
        $asteriskClient->setGlobalVar('SomeVar', 'SomeVal');
        $this->assertTrue(true, true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testUnloadModule()
    {
        $asteriskClient = $this->createAsteriskClientWithGuzzleClientStub([]);
        $asteriskClient->unloadModule('SomeModule');
        $this->assertTrue(true, true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testLoadModule()
    {
        $asteriskClient = $this->createAsteriskClientWithGuzzleClientStub([]);
        $asteriskClient->loadModule('SomeModule');
        $this->assertTrue(true, true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testDeleteObject()
    {
        $asteriskClient = $this->createAsteriskClientWithGuzzleClientStub([]);
        $asteriskClient->deleteObject('SomeChannelId', 'SomeObject', 'SomeId');
        $this->assertTrue(true, true);
    }

    /**
     * @param $expectedResponse
     * @return Asterisk
     * @throws \ReflectionException
     */
    private function createAsteriskClientWithGuzzleClientStub($expectedResponse)
    {
        $guzzleClientStub = $this->createMock(Client::class);
        $guzzleClientStub->method('request')
            // TODO: Test for correct parameter translation via with() method here?
            //  ->with()
            ->willReturn(new Response(
                    200, [], json_encode($expectedResponse), '1.1', 'SomeReason')
            );

        /**
         * @var Client $guzzleClientStub
         */
        return new Asterisk('SomeUser', 'SomePw', [], $guzzleClientStub);
    }

    /**
     * @return Asterisk
     * @throws \ReflectionException
     */
    private function createAsteriskClientThatThrowsException()
    {
        $guzzleClientStub = $this->createMock(Client::class);
        $guzzleClientStub->method('request')
            // TODO: Test for correct parameter translation via with() method here?
            //  ->with()
            ->willThrowException(
                new ServerException('Internal Server Error',
                    new Request('PUT', '/asterisk/test')
                )
            );

        /**
         * @var Client $guzzleClientStub
         */
        return new Asterisk('SomeUser', 'SomePw', [], $guzzleClientStub);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testPutRequestException()
    {
        $asteriskClient = $this->createAsteriskClientThatThrowsException();
        $this->expectException('GuzzleHttp\Exception\ServerException');
        $asteriskClient->updateObject(
            'SomeConfigClass',
            'SomeObjectType',
            'SomeId',
            ['SomeAttribute' => 'SomeValue', 'SomeAttribute1' => 'SomeValue1', 'SomeAttribute2' => 'SomeValue2']
        );
    }
}