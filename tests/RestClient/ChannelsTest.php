<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\Tests\RestClient;

use AriStasisApp\Model\{Channel, LiveRecording, Playback, Variable};
use AriStasisApp\RestClient\Channels;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * Class ChannelsTest
 * @package AriStasisApp\Tests\RestClient
 */
class ChannelsTest extends TestCase
{
    /**
     * @return array
     */
    public function channelsInstanceProvider()
    {
        return [
            'example channel' => [
                [
                    'name' => 'SIP/foo-0000a7e3',
                    'language' => 'en',
                    'accountcode' => 'TestAccount',
                    'channelvars' => [
                        'testVar' => 'correct',
                        'testVar2' => 'nope'
                    ],
                    'caller' => [
                        'name' => 'ExampleName',
                        'number' => 'ExampleNumber'
                    ],
                    'creationtime' => '2016-12-20 13:45:28 UTC',
                    'state' => 'Up',
                    'connected' => [
                        'name' => 'ExampleName2',
                        'number' => 'ExampleNumber2'
                    ],
                    'dialplan' => [
                        'context' => 'ExampleContext',
                        'exten' => 'ExampleExten',
                        'priority' => '3'
                    ],
                    'id' => '123456'
                ]
            ],
        ];
    }

    /**
     * @dataProvider channelsInstanceProvider
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testContinueInDialPlan()
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->continueInDialPlan('SomeChannelId', []);
        $this->assertTrue(true, true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testRecord()
    {
        $channelsClient = $this->createChannelsClient([
            'talking_duration' => '3',
            'name' => 'ExampleName',
            'target_uri' => 'ExampleUri',
            'format' => 'wav',
            'cause' => 'ExampleCause',
            'state' => 'paused',
            'duration' => '4',
            'silence_duration' => '2'
        ]);
        $resultLiveRecording = $channelsClient->record('12345', 'RecordName', 'wav');

        $this->assertInstanceOf(LiveRecording::class, $resultLiveRecording);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testSetChannelVar()
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->setChannelVar('SomeChannelId', 'SomeVar', 'SomeVal');
        $this->assertTrue(true, true);
    }

    /**
     * @dataProvider channelsInstanceProvider
     * @param string[] $exampleChannel
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testSnoopChannel(array $exampleChannel)
    {
        $channelsClient = $this->createChannelsClient($exampleChannel);
        $resultChannel = $channelsClient->snoopChannel('12345', 'TestApp');

        $this->assertInstanceOf(Channel::class, $resultChannel);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testRedirect()
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->redirect('SomeChannelId', 'SomeEndpoint');
        $this->assertTrue(true, true);
    }

    /**
     * @dataProvider channelsInstanceProvider
     * @param string[] $exampleChannel
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testList(array $exampleChannel)
    {
        $channelsClient = $this->createChannelsClient(
            [$exampleChannel, $exampleChannel, $exampleChannel]
        );
        $resultList = $channelsClient->list();

        $this->assertIsArray($resultList);
        foreach ($resultList as $resultChannel) {
            $this->assertInstanceOf(Channel::class, $resultChannel);
        }
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testGetChannelVar()
    {
        $channelsClient = $this->createChannelsClient(['value' => 'testValue']);
        $resultVariable = $channelsClient->getChannelVar('12345', 'TestVar');

        $this->assertInstanceOf(Variable::class, $resultVariable);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testMute()
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->mute('SomeChannelId');
        $this->assertTrue(true, true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testStartSilence()
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->startSilence('SomeChannelId');
        $this->assertTrue(true, true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testDial()
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->dial('SomeChannelId', 'callerId', 500);
        $this->assertTrue(true, true);
    }

    /**
     * @dataProvider channelsInstanceProvider
     * @param string[] $exampleChannel
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testGet(array $exampleChannel)
    {
        $channelsClient = $this->createChannelsClient($exampleChannel);
        $resultChannel = $channelsClient->get('12345');

        $this->assertInstanceOf(Channel::class, $resultChannel);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testSendDtmf()
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->sendDtmf('SomeChannelId', '1234');
        $this->assertTrue(true, true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testUnHold()
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->unHold('SomeChannelId');
        $this->assertTrue(true, true);
    }

    /**
     * @dataProvider channelsInstanceProvider
     * @param string[] $exampleChannel
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testCreate(array $exampleChannel)
    {
        $channelsClient = $this->createChannelsClient($exampleChannel);
        $resultChannel = $channelsClient->create('SomeEndpoint', 'SomeApp');

        $this->assertInstanceOf(Channel::class, $resultChannel);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testStartMoh()
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->startMoh('SomeChannelId', 'SomeMohClass');
        $this->assertTrue(true, true);
    }

    /**
     * @dataProvider channelsInstanceProvider
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testRing()
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->ring('SomeChannelId');
        $this->assertTrue(true, true);
    }

    /**
     * @dataProvider channelsInstanceProvider
     * @param string[] $exampleChannel
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testOriginate(array $exampleChannel)
    {
        $channelsClient = $this->createChannelsClient($exampleChannel);
        $resultChannel = $channelsClient->originate('SomeEndpoint');

        $this->assertInstanceOf(Channel::class, $resultChannel);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testPlayWithId()
    {
        $channelsClient = $this->createChannelsClient([
            'next_media_uri' => 'ExampleUri',
            'target_uri' => 'ExampleTargetUri',
            'language' => 'en',
            'state' => 'queued',
            'media_uri' => 'ExampleMediaRui',
            'id' => 'ExampleId'
        ]);
        $resultPlayback = $channelsClient->playWithId('12345', 'PlaybackId', ['sound:exampleSound']);

        $this->assertInstanceOf(Playback::class, $resultPlayback);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testHold()
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->hold('SomeChannelId');
        $this->assertTrue(true, true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testUnMute()
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->unMute('SomeChannelId');
        $this->assertTrue(true, true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testPlay()
    {
        $channelsClient = $this->createChannelsClient([
            'next_media_uri' => 'ExampleUri',
            'target_uri' => 'ExampleTargetUri',
            'language' => 'en',
            'state' => 'queued',
            'media_uri' => 'ExampleMediaRui',
            'id' => 'ExampleId'
        ]);
        $resultPlayback = $channelsClient->play('12345', ['sound:exampleSound']);

        $this->assertInstanceOf(Playback::class, $resultPlayback);
    }

    /**
     * @dataProvider channelsInstanceProvider
     * @param string[] $exampleChannel
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testOriginateWithId(array $exampleChannel)
    {
        $channelsClient = $this->createChannelsClient($exampleChannel);
        $resultChannel = $channelsClient->originateWithId('SomeChannelId', 'SomeEndpoint');

        $this->assertInstanceOf(Channel::class, $resultChannel);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testStopSilence()
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->stopSilence('SomeChannelId');
        $this->assertTrue(true, true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testStopMoh()
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->stopMoh('SomeChannelId');
        $this->assertTrue(true, true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testRingStop()
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->ringStop('SomeChannelId');
        $this->assertTrue(true, true);
    }

    /**
     * @dataProvider channelsInstanceProvider
     * @param string[] $exampleChannel
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testSnoopChannelWithId(array $exampleChannel)
    {
        $channelsClient = $this->createChannelsClient($exampleChannel);
        $resultChannel = $channelsClient->snoopChannelWithId('12345', 'SnoopId', 'TestApp');

        $this->assertInstanceOf(Channel::class, $resultChannel);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testHangup()
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->hangup('SomeChannelId', 'SomeReason');
        $this->assertTrue(true, true);
    }

    /**
     * @dataProvider channelsInstanceProvider
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testAnswer()
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->answer('SomeChannelId');
        $this->assertTrue(true, true);
    }

    /**
     * @param $expectedResponse
     * @return Channels
     * @throws \ReflectionException
     */
    private function createChannelsClient($expectedResponse)
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
        return new Channels('SomeUser', 'SomePw', [], $guzzleClientStub);
    }

    /**
     * @return Channels
     * @throws \ReflectionException
     */
    private function createChannelsClientThatThrowsException()
    {
        $guzzleClientStub = $this->createMock(Client::class);
        $guzzleClientStub->method('request')
            // TODO: Test for correct parameter translation via with() method here?
            //  ->with()
            ->willThrowException(
                new ServerException('Internal Server Error',
                    new Request('POST', '/channels/test')
                )
            );

        /**
         * @var Client $guzzleClientStub
         */
        return new Channels('SomeUser', 'SomePw', [], $guzzleClientStub);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testPostException()
    {
        $channelsClient = $this->createChannelsClientThatThrowsException();
        $this->expectException('GuzzleHttp\Exception\ServerException');
        $channelsClient->sendDtmf('SomeChannelId', '1234');
        $this->assertTrue(true, true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testGetException()
    {
        $channelsClient = $this->createChannelsClientThatThrowsException();
        $this->expectException('GuzzleHttp\Exception\ServerException');
        $channelsClient->get('SomeChannelId');
        $this->assertTrue(true, true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testDeleteException()
    {
        $channelsClient = $this->createChannelsClientThatThrowsException();
        $this->expectException('GuzzleHttp\Exception\ServerException');
        $channelsClient->unHold('SomeChannelId');
        $this->assertTrue(true, true);
    }
}
