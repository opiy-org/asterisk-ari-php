<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\Tests\rest_clients;

use AriStasisApp\models\Playback;
use AriStasisApp\rest_clients\Playbacks;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class PlaybacksTest extends TestCase
{

    /**
     * @return array
     */
    public function playbackInstanceProvider()
    {
        return [
            'example mailbox' => [
                [
                    'next_media_uri' => 'ExampleUri',
                    'target_uri' => 'ExampleTargetUri',
                    'language' => 'en',
                    'state' => 'queued',
                    'media_uri' => 'ExampleMediaRui',
                    'id' => 'ExampleId'
                ]
            ]
        ];
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testStop()
    {
        $playbacksClient = $this->createPlaybacksClient([]);
        $playbacksClient->stop('SomePlaybackId');
        $this->assertTrue(true, true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testControl()
    {
        $playbacksClient = $this->createPlaybacksClient([]);
        $playbacksClient->control('SomePlaybackId', 'ExampleOperation');
        $this->assertTrue(true, true);
    }

    /**
     * @dataProvider playbackInstanceProvider
     * @param string[] $examplePlayback
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testGet(array $examplePlayback)
    {
        $playbacksClient = $this->createPlaybacksClient($examplePlayback);
        $resultPlayback = $playbacksClient->get('12345');

        $this->assertInstanceOf(Playback::class, $resultPlayback);
    }

    /**
     * @param $expectedResponse
     * @return Playbacks
     * @throws \ReflectionException
     */
    private function createPlaybacksClient($expectedResponse)
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
        return new Playbacks('SomeUser', 'SomePw', [], $guzzleClientStub);
    }
}
