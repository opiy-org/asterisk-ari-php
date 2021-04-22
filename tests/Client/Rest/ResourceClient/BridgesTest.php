<?php

/** @copyright 2020 ng-voice GmbH */

namespace OpiyOrg\AriClient\Tests\Client\Rest\ResourceClient;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use OpiyOrg\AriClient\Client\Rest\Resource\Bridges;
use OpiyOrg\AriClient\Client\Rest\Settings;
use OpiyOrg\AriClient\Exception\AsteriskRestInterfaceException;
use OpiyOrg\AriClient\Model\{Bridge, LiveRecording, Playback};
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * Class BridgesTest
 *
 * @package OpiyOrg\AriClient\Tests\Rest
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class BridgesTest extends TestCase
{
    /**
     * @return array
     */
    public function bridgesInstanceProvider(): array
    {
        return [
            'example bridge' => [
                [
                    'bridge_class'    => 'ExampleClass',
                    'bridge_type'     => 'mixing',
                    'channels'        => [],
                    'creator'         => 'ExampleCreator',
                    'id'              => 'id1',
                    'name'            => 'ExampleName',
                    'technology'      => 'ExampleTechnology',
                    'video_mode'      => 'none',
                    'video_source_id' => 'VideoId',
                    'creationtime'    => '1234567',
                ],
            ],
        ];
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testStopMoh(): void
    {
        $bridgesClient = $this->createBridgesClientWithGuzzleClientStub([]);
        $bridgesClient->stopMoh('SomeBridgeId');
        $this->assertTrue(true, true);
    }

    /**
     * @dataProvider bridgesInstanceProvider
     * @param string[] $exampleBridge
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testCreateWithId(array $exampleBridge): void
    {
        $bridgesClient = $this->createBridgesClientWithGuzzleClientStub($exampleBridge);
        $resultChannel = $bridgesClient->createWithId('SomeBridgeId');

        $this->assertInstanceOf(Bridge::class, $resultChannel);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testPlay(): void
    {
        $bridgesClient = $this->createBridgesClientWithGuzzleClientStub(
            [
            'next_media_uri' => 'ExampleUri',
            'target_uri' => 'ExampleTargetUri',
            'language' => 'en',
            'state' => 'queued',
            'media_uri' => 'ExampleMediaRui',
            'id' => 'ExampleId'
            ]
        );
        $resultPlayback = $bridgesClient->play('12345', ['sound:exampleSound']);

        $this->assertInstanceOf(Playback::class, $resultPlayback);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testStartMoh(): void
    {
        $bridgesClient = $this->createBridgesClientWithGuzzleClientStub([]);
        $bridgesClient->startMoh('SomeBridgeId', 'SomeMohClass');
        $this->assertTrue(true, true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testDestroy(): void
    {
        $bridgesClient = $this->createBridgesClientWithGuzzleClientStub([]);
        $bridgesClient->destroy('SomeChannelId');
        $this->assertTrue(true, true);
    }

    /**
     * @dataProvider bridgesInstanceProvider
     * @param array $exampleBridge
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testList(array $exampleBridge): void
    {
        $bridgesClient = $this->createBridgesClientWithGuzzleClientStub(
            [$exampleBridge, $exampleBridge, $exampleBridge]
        );
        $resultList = $bridgesClient->list();

        $this->assertIsArray($resultList);
        foreach ($resultList as $resultChannel) {
            $this->assertInstanceOf(Bridge::class, $resultChannel);
        }
    }

    /**
     * @dataProvider bridgesInstanceProvider
     * @param string[] $exampleChannel
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testGet(array $exampleChannel): void
    {
        $bridgesClient = $this->createBridgesClientWithGuzzleClientStub($exampleChannel);
        $resultChannel = $bridgesClient->get('12345');

        $this->assertInstanceOf(Bridge::class, $resultChannel);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testSetVideoSource(): void
    {
        $bridgesClient = $this->createBridgesClientWithGuzzleClientStub([]);
        $bridgesClient->setVideoSource('SomeChannelId', 'SomeChannelId');
        $this->assertTrue(true, true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testPlayWithId(): void
    {
        $bridgesClient = $this->createBridgesClientWithGuzzleClientStub(
            [
            'next_media_uri' => 'ExampleUri',
            'target_uri' => 'ExampleTargetUri',
            'language' => 'en',
            'state' => 'queued',
            'media_uri' => 'ExampleMediaRui',
            'id' => 'ExampleId'
            ]
        );
        $resultPlayback = $bridgesClient->playWithId('12345', 'SomePlaybackId', ['sound:exampleSound']);

        $this->assertInstanceOf(Playback::class, $resultPlayback);
    }

    /**
     * @dataProvider bridgesInstanceProvider
     * @param string[] $exampleBridge
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testCreate(array $exampleBridge): void
    {
        $bridgesClient = $this->createBridgesClientWithGuzzleClientStub($exampleBridge);
        $resultChannel = $bridgesClient->create();

        $this->assertInstanceOf(Bridge::class, $resultChannel);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testClearVideoSource(): void
    {
        $bridgesClient = $this->createBridgesClientWithGuzzleClientStub([]);
        $bridgesClient->clearVideoSource('SomeChannelId');
        $this->assertTrue(true, true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testRecord(): void
    {
        $bridgesClient = $this->createBridgesClientWithGuzzleClientStub(
            [
                'talking_duration' => 3,
                'name'             => 'ExampleName',
                'target_uri'       => 'ExampleUri',
                'format'           => 'wav',
                'cause'            => 'ExampleCause',
                'state'            => 'paused',
                'duration'         => 4,
                'silence_duration' => 2,
            ]
        );
        $resultLiveRecording = $bridgesClient->record('12345', 'RecordName', 'wav');

        $this->assertInstanceOf(LiveRecording::class, $resultLiveRecording);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testAddChannel(): void
    {
        $bridgesClient = $this->createBridgesClientWithGuzzleClientStub([]);
        $bridgesClient->addChannel('SomeChannelId', []);
        $this->assertTrue(true, true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testRemoveChannel(): void
    {
        $bridgesClient = $this->createBridgesClientWithGuzzleClientStub([]);
        $bridgesClient->removeChannel('SomeChannelId', []);
        $this->assertTrue(true, true);
    }

    /**
     * @param $expectedResponse
     * @return Bridges
     * @throws ReflectionException
     */
    private function createBridgesClientWithGuzzleClientStub($expectedResponse): Bridges
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
        return new Bridges(
            new Settings('SomeUser', 'SomePw'),
            $guzzleClientStub
        );
    }
}
