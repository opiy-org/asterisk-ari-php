<?php

/** @copyright 2020 ng-voice GmbH */

namespace NgVoice\AriClient\Tests\Client\Rest\ResourceClient;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use NgVoice\AriClient\Client\Rest\Resource\Playbacks;
use NgVoice\AriClient\Client\Rest\Settings;
use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use NgVoice\AriClient\Model\Playback;
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * Class PlaybacksTest
 *
 * @package NgVoice\AriClient\Tests\Rest
 */
class PlaybacksTest extends TestCase
{
    /**
     * @return array
     */
    public function playbackInstanceProvider(): array
    {
        return [
            'example mailbox' => [
                [
                    'next_media_uri' => 'ExampleUri',
                    'target_uri'     => 'ExampleTargetUri',
                    'language'       => 'en',
                    'state'          => 'queued',
                    'media_uri'      => 'ExampleMediaRui',
                    'id'             => 'ExampleId',
                ],
            ],
        ];
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testStop(): void
    {
        $playbacksClient = $this->createPlaybacksClient([]);
        $playbacksClient->stop('SomePlaybackId');
        $this->assertTrue(true, true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testControl(): void
    {
        $playbacksClient = $this->createPlaybacksClient([]);
        $playbacksClient->control('SomePlaybackId', 'ExampleOperation');
        $this->assertTrue(true, true);
    }

    /**
     * @dataProvider playbackInstanceProvider
     * @param string[] $examplePlayback
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testGet(array $examplePlayback): void
    {
        $playbacksClient = $this->createPlaybacksClient($examplePlayback);
        $resultPlayback = $playbacksClient->get('12345');

        $this->assertInstanceOf(Playback::class, $resultPlayback);
    }

    /**
     * @param $expectedResponse
     * @return Playbacks
     * @throws ReflectionException
     */
    private function createPlaybacksClient($expectedResponse): Playbacks
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
        return new Playbacks(
            new Settings('SomeUser', 'SomePw'),
            $guzzleClientStub
        );
    }
}
