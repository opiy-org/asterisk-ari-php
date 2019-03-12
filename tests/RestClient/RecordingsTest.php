<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */


namespace AriStasisApp\Tests\RestClient;

use AriStasisApp\Model\LiveRecording;
use AriStasisApp\Model\StoredRecording;
use AriStasisApp\RestClient\Recordings;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * Class RecordingsTest
 * @package AriStasisApp\Tests\RestClient
 */
class RecordingsTest extends TestCase
{
    /**
     * @return array
     */
    public function recordingInstanceProvider()
    {
        return [
            'example live recording' => [
                [
                    'talking_duration' => '3',
                    'name' => 'ExampleName',
                    'target_uri' => 'ExampleUri',
                    'format' => 'wav',
                    'cause' => 'ExampleCause',
                    'state' => 'paused',
                    'duration' => '4',
                    'silence_duration' => '2'
                ]
            ]
        ];
    }

    /**
     * @dataProvider recordingInstanceProvider
     * @param array $exampleLiveRecording
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testGetLive(array $exampleLiveRecording)
    {
        $recordingsClient = $this->createRecordingsClientWithGuzzleClientStub($exampleLiveRecording);
        $resultChannel = $recordingsClient->getLive('12345');

        $this->assertInstanceOf(LiveRecording::class, $resultChannel);
    }

    /**
     * @throws \ReflectionException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testCopyStored()
    {
        $exampleStoredRecording = [
            'format' => 'ExampleFormat',
            'name' => 'ExampleName'
        ];
        $recordingsClient = $this->createRecordingsClientWithGuzzleClientStub($exampleStoredRecording);
        $resultRecording = $recordingsClient->copyStored('ExampeRecordingName', 'ExampleDestinationRecordingName');

        $this->assertInstanceOf(StoredRecording::class, $resultRecording);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testGetStored()
    {
        $exampleStoredRecording = [
            'format' => 'ExampleFormat',
            'name' => 'ExampleName'
        ];
        $recordingsClient = $this->createRecordingsClientWithGuzzleClientStub($exampleStoredRecording);
        $resultRecording = $recordingsClient->getStored('12345');

        $this->assertInstanceOf(StoredRecording::class, $resultRecording);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testListStored()
    {
        $exampleStoredRecording = [
            'format' => 'ExampleFormat',
            'name' => 'ExampleName'
        ];
        $recordingsClient = $this->createRecordingsClientWithGuzzleClientStub(
            [$exampleStoredRecording, $exampleStoredRecording, $exampleStoredRecording]
        );
        $resultList = $recordingsClient->listStored();

        $this->assertIsArray($resultList);
        foreach ($resultList as $resultStoredRecording) {
            $this->assertInstanceOf(StoredRecording::class, $resultStoredRecording);
        }
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testDeleteStored()
    {
        $recordingsClient = $this->createRecordingsClientWithGuzzleClientStub([]);
        $recordingsClient->deleteStored('ExampleRecordingName');
        $this->assertTrue(true, true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testCancel()
    {
        $recordingsClient = $this->createRecordingsClientWithGuzzleClientStub([]);
        $recordingsClient->cancel('ExampleRecordingName');
        $this->assertTrue(true, true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testStop()
    {
        $recordingsClient = $this->createRecordingsClientWithGuzzleClientStub([]);
        $recordingsClient->stop('ExampleRecordingName');
        $this->assertTrue(true, true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testPause()
    {
        $recordingsClient = $this->createRecordingsClientWithGuzzleClientStub([]);
        $recordingsClient->pause('ExampleRecordingName');
        $this->assertTrue(true, true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testUnpause()
    {
        $recordingsClient = $this->createRecordingsClientWithGuzzleClientStub([]);
        $recordingsClient->unpause('ExampleRecordingName');
        $this->assertTrue(true, true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testMute()
    {
        $recordingsClient = $this->createRecordingsClientWithGuzzleClientStub([]);
        $recordingsClient->mute('ExampleRecordingName');
        $this->assertTrue(true, true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testUnmute()
    {
        $recordingsClient = $this->createRecordingsClientWithGuzzleClientStub([]);
        $recordingsClient->unmute('ExampleRecordingName');
        $this->assertTrue(true, true);
    }

    /**
     * @param $expectedResponse
     * @return Recordings
     * @throws \ReflectionException
     */
    private function createRecordingsClientWithGuzzleClientStub($expectedResponse)
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
        return new Recordings('SomeUser', 'SomePw', [], $guzzleClientStub);
    }
}
