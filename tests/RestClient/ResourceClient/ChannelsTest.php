<?php

/** @copyright 2019 ng-voice GmbH */

namespace AriStasisApp\Tests\RestClient\ResourceClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use NgVoice\AriClient\Models\{Channel, LiveRecording, Playback, Variable};
use NgVoice\AriClient\RestClient\ResourceClient\Channels;
use NgVoice\AriClient\RestClient\Settings;
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * Class ChannelsTest
 *
 * @package AriStasisApp\Tests\RestClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class ChannelsTest extends TestCase
{
    /**
     * @return array
     */
    public function channelsInstanceProvider(): array
    {
        return [
            'example channel' => [
                [
                    'name'         => 'SIP/foo-0000a7e3',
                    'language'     => 'en',
                    'accountcode'  => 'TestAccount',
                    'channelvars'  => [
                        'testVar'  => 'correct',
                        'testVar2' => 'nope',
                    ],
                    'caller'       => [
                        'name'   => 'ExampleName',
                        'number' => 'ExampleNumber',
                    ],
                    'creationtime' => '2016-12-20 13:45:28 UTC',
                    'state'        => 'Up',
                    'connected'    => [
                        'name'   => 'ExampleName2',
                        'number' => 'ExampleNumber2',
                    ],
                    'dialplan'     => [
                        'context'  => 'ExampleContext',
                        'exten'    => 'ExampleExten',
                        'priority' => '3',
                    ],
                    'id'           => '123456',
                ],
            ],
        ];
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testContinueInDialPlan(): void
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->continueInDialPlan('SomeChannelId', []);
        $this->assertTrue(true, true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testRecord(): void
    {
        $channelsClient = $this->createChannelsClient(
            [
                'talking_duration' => '3',
                'name'             => 'ExampleName',
                'target_uri'       => 'ExampleUri',
                'format'           => 'wav',
                'cause'            => 'ExampleCause',
                'state'            => 'paused',
                'duration'         => '4',
                'silence_duration' => '2',
            ]
        );
        $resultLiveRecording = $channelsClient->record('12345', 'RecordName', 'wav');

        $this->assertInstanceOf(LiveRecording::class, $resultLiveRecording);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testSetChannelVar(): void
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->setChannelVar('SomeChannelId', 'SomeVar', 'SomeVal');
        $this->assertTrue(true, true);
    }

    /**
     * @dataProvider channelsInstanceProvider
     * @param string[] $exampleChannel
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testSnoopChannel(array $exampleChannel): void
    {
        $channelsClient = $this->createChannelsClient($exampleChannel);
        $resultChannel = $channelsClient->snoopChannel('12345', 'TestApp');

        $this->assertInstanceOf(Channel::class, $resultChannel);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testRedirect(): void
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->redirect('SomeChannelId', 'SomeEndpoint');
        $this->assertTrue(true, true);
    }

    /**
     * @dataProvider channelsInstanceProvider
     * @param string[] $exampleChannel
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testList(array $exampleChannel): void
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
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testGetChannelVar(): void
    {
        $channelsClient = $this->createChannelsClient(['value' => 'testValue']);
        $resultVariable = $channelsClient->getChannelVar('12345', 'TestVar');

        $this->assertInstanceOf(Variable::class, $resultVariable);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testMute(): void
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->mute('SomeChannelId');
        $this->assertTrue(true, true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testStartSilence(): void
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->startSilence('SomeChannelId');
        $this->assertTrue(true, true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testDial(): void
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->dial('SomeChannelId', 'callerId', 500);
        $this->assertTrue(true, true);
    }

    /**
     * @dataProvider channelsInstanceProvider
     * @param string[] $exampleChannel
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testGet(array $exampleChannel): void
    {
        $channelsClient = $this->createChannelsClient($exampleChannel);
        $resultChannel = $channelsClient->get('12345');

        $this->assertInstanceOf(Channel::class, $resultChannel);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testSendDtmf(): void
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->sendDtmf('SomeChannelId', '1234');
        $this->assertTrue(true, true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testUnHold(): void
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->unHold('SomeChannelId');
        $this->assertTrue(true, true);
    }

    /**
     * @dataProvider channelsInstanceProvider
     * @param string[] $exampleChannel
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testCreate(array $exampleChannel): void
    {
        $channelsClient = $this->createChannelsClient($exampleChannel);
        $resultChannel = $channelsClient->create('SomeEndpoint', 'SomeApp');

        $this->assertInstanceOf(Channel::class, $resultChannel);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testStartMoh(): void
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->startMoh('SomeChannelId', 'SomeMohClass');
        $this->assertTrue(true, true);
    }

    /**
     * @dataProvider channelsInstanceProvider
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testRing(): void
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->ring('SomeChannelId');
        $this->assertTrue(true, true);
    }

    /**
     * @dataProvider channelsInstanceProvider
     * @param string[] $exampleChannel
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testOriginate(array $exampleChannel): void
    {
        $channelsClient = $this->createChannelsClient($exampleChannel);
        $resultChannel = $channelsClient->originate('SomeEndpoint', []);

        $this->assertInstanceOf(Channel::class, $resultChannel);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testPlayWithId(): void
    {
        $channelsClient = $this->createChannelsClient(
            [
                'next_media_uri' => 'ExampleUri',
                'target_uri'     => 'ExampleTargetUri',
                'language'       => 'en',
                'state'          => 'queued',
                'media_uri'      => 'ExampleMediaRui',
                'id'             => 'ExampleId',
            ]
        );
        $resultPlayback =
            $channelsClient->playWithId('12345', 'PlaybackId', ['sound:exampleSound']);

        $this->assertInstanceOf(Playback::class, $resultPlayback);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testHold(): void
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->hold('SomeChannelId');
        $this->assertTrue(true, true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testMove(): void
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->move('SomeChannelId', 'AppName', [2, 3, 5]);
        $this->assertTrue(true, true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testUnMute(): void
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->unMute('SomeChannelId');
        $this->assertTrue(true, true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testPlay(): void
    {
        $channelsClient = $this->createChannelsClient(
            [
                'next_media_uri' => 'ExampleUri',
                'target_uri'     => 'ExampleTargetUri',
                'language'       => 'en',
                'state'          => 'queued',
                'media_uri'      => 'ExampleMediaRui',
                'id'             => 'ExampleId',
            ]
        );
        $resultPlayback = $channelsClient->play('12345', ['sound:exampleSound']);

        $this->assertInstanceOf(Playback::class, $resultPlayback);
    }

    /**
     * @dataProvider channelsInstanceProvider
     * @param string[] $exampleChannel
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testOriginateWithId(array $exampleChannel): void
    {
        $channelsClient = $this->createChannelsClient($exampleChannel);
        $resultChannel =
            $channelsClient->originateWithId('SomeChannelId', 'SomeEndpoint', []);

        $this->assertInstanceOf(Channel::class, $resultChannel);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testStopSilence(): void
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->stopSilence('SomeChannelId');
        $this->assertTrue(true, true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testStopMoh(): void
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->stopMoh('SomeChannelId');
        $this->assertTrue(true, true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testRingStop(): void
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->ringStop('SomeChannelId');
        $this->assertTrue(true, true);
    }

    /**
     * @dataProvider channelsInstanceProvider
     * @param string[] $exampleChannel
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testSnoopChannelWithId(array $exampleChannel): void
    {
        $channelsClient = $this->createChannelsClient($exampleChannel);
        $resultChannel =
            $channelsClient->snoopChannelWithId('12345', 'SnoopId', 'TestApp');

        $this->assertInstanceOf(Channel::class, $resultChannel);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testHangup(): void
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->hangup('SomeChannelId', 'SomeReason');
        $this->assertTrue(true, true);
    }

    /**
     * @dataProvider channelsInstanceProvider
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testAnswer(): void
    {
        $channelsClient = $this->createChannelsClient([]);
        $channelsClient->answer('SomeChannelId');
        $this->assertTrue(true, true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testPostException(): void
    {
        $channelsClient = $this->createChannelsClientThatThrowsException();
        $this->expectException(AsteriskRestInterfaceException::class);
        $channelsClient->sendDtmf('SomeChannelId', '1234');
        $this->assertTrue(true, true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testGetException(): void
    {
        $channelsClient = $this->createChannelsClientThatThrowsException();
        $this->expectException(AsteriskRestInterfaceException::class);
        $channelsClient->get('SomeChannelId');
        $this->assertTrue(true, true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testDeleteException(): void
    {
        $channelsClient = $this->createChannelsClientThatThrowsException();
        $this->expectException(AsteriskRestInterfaceException::class);
        $channelsClient->unHold('SomeChannelId');
        $this->assertTrue(true, true);
    }

    /**
     * @param $expectedResponse
     * @return Channels
     * @throws ReflectionException
     */
    private function createChannelsClient($expectedResponse): Channels
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
        return new Channels(
            new Settings('SomeUser', 'SomePw'),
            $guzzleClientStub
        );
    }

    /**
     * @return Channels
     * @throws ReflectionException
     */
    private function createChannelsClientThatThrowsException(): Channels
    {
        $guzzleClientStub = $this->createMock(Client::class);
        $guzzleClientStub->method('request')
            // TODO: Test for correct parameter translation via with() method here?
            //  ->with()
            ->willThrowException(
                new ServerException(
                    'Internal Server Error',
                    new Request('POST', '/channels/test')
                )
            );

        /**
         * @var Client $guzzleClientStub
         */
        return new Channels(
            new Settings('SomeUser', 'SomePw'),
            $guzzleClientStub
        );
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testRtpStatistics(): void
    {
        $channelsClient = $this->createChannelsClient(
            [
                'txjitter' => 2.34,
                'local_stdevjitter' => 4.2243,
                'local_minjitter' => 8.5323,
                'rxjitter' => 1.456,
                'rtt' => 932.33,
                'stdevrtt' => 23.112,
                'local_maxjitter' => 28.5323,
                'maxrtt' => 12.56,
                'local_normdevrxploss' => 932.33,
                'local_normdevjitter' => 12.56,
                'te_minrxploss' => 2.33,
                'txoctetcount' => 125,
                'rxoctetcount' => 33,
                'local_maxrxploss' => 12.56,
                'remote_normdevrxploss' => 12.56,
                'local_stdevrxploss' => 12.56,
                'remote_stdevjitter' => 932.33,
                'txploss' => 83,
                'remote_stdevrxploss' => 212.33,
                'remote_maxrxploss' => 212.33,
                'txcount' => 126,
                'remote_minjitter' => 8.33,
                'remote_maxjitter' => 212.33,
                'remote_ssrc' => 16,
                'channel_uniqueid' => 'id',
                'rxcount' => 33,
                'rxploss' => 3,
                'remote_normdevjitter' => 8.33,
                'local_ssrc' => 3,
                'minrtt' => 8.33,
                'local_minrxploss' => 32.3,
                'normdevrtt' => 8.33
            ]
        );
        $channelsClient->rtpStatistics('SomeChannelId');
        $this->assertTrue(true, true);
    }

    /**
     * @dataProvider channelsInstanceProvider
     * @param array $exampleChannel
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testExternalMedia(array $exampleChannel): void
    {
        $channelsClient = $this->createChannelsClient(
            $exampleChannel
        );

        $externalMedia = $channelsClient->externalMedia(
            'ExampleApp',
            '127.0.0.1:8003',
            'g722'
        );

        $this->assertInstanceOf(Channel::class, $externalMedia);
    }
}
