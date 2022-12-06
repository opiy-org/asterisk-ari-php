<?php

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Client\Rest\ResourceClient;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use OpiyOrg\AriClient\Client\Rest\Resource\Recordings;
use OpiyOrg\AriClient\Client\Rest\Settings;
use OpiyOrg\AriClient\Exception\AsteriskRestInterfaceException;
use OpiyOrg\AriClient\Model\{LiveRecording, StoredRecording};
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * Class RecordingsTest
 *
 * @package OpiyOrg\AriClient\Tests\Rest
 * @author Lukas Stermann <lukas@ng-voice.com>
 * @author Ahmad Hussain <ahmad@ng-voice.com>
 */
class RecordingsTest extends TestCase
{
    /**
     * @return array
     */
    public function recordingInstanceProvider(): array
    {
        return [
            'example live recording' => [
                [
                    'talking_duration' => 3,
                    'name' => 'ExampleName',
                    'target_uri' => 'ExampleUri',
                    'format' => 'wav',
                    'cause' => 'ExampleCause',
                    'state' => 'paused',
                    'duration' => 4,
                    'silence_duration' => 2,
                ],
            ],
        ];
    }

    /**
     * @dataProvider recordingInstanceProvider
     * @param array $exampleLiveRecording
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testGetLive(array $exampleLiveRecording): void
    {
        $recordingsClient = $this->createRecordingsClientWithGuzzleClientStub($exampleLiveRecording);
        $resultChannel = $recordingsClient->getLive('12345');

        $this->assertInstanceOf(LiveRecording::class, $resultChannel);
    }

    /**
     * @throws ReflectionException
     * @throws AsteriskRestInterfaceException
     */
    public function testGetStoredFile(): void
    {
        $recordingsClient = $this->createRecordingsClientWithGuzzleClientStub([]);
        $recordingsClient->getStoredFile(
            'ExampleRecordingName',
            '/recordings/stored/filename'
        );
        $this->assertTrue(true);
    }

    /**
     * @throws ReflectionException
     * @throws AsteriskRestInterfaceException
     */
    public function testCopyStored(): void
    {
        $exampleStoredRecording = [
            'format' => 'ExampleFormat',
            'name' => 'ExampleName',
        ];
        $recordingsClient = $this->createRecordingsClientWithGuzzleClientStub($exampleStoredRecording);
        $resultRecording = $recordingsClient->copyStored('ExampeRecordingName', 'ExampleDestinationRecordingName');

        $this->assertInstanceOf(StoredRecording::class, $resultRecording);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testGetStored(): void
    {
        $exampleStoredRecording = [
            'format' => 'ExampleFormat',
            'name' => 'ExampleName',
        ];
        $recordingsClient = $this->createRecordingsClientWithGuzzleClientStub($exampleStoredRecording);
        $resultRecording = $recordingsClient->getStored('12345');

        $this->assertInstanceOf(StoredRecording::class, $resultRecording);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testListStored(): void
    {
        $exampleStoredRecording = [
            'format' => 'ExampleFormat',
            'name' => 'ExampleName',
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
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testDeleteStored(): void
    {
        $recordingsClient = $this->createRecordingsClientWithGuzzleClientStub([]);
        $recordingsClient->deleteStored('ExampleRecordingName');
        $this->assertTrue(true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testCancel(): void
    {
        $recordingsClient = $this->createRecordingsClientWithGuzzleClientStub([]);
        $recordingsClient->cancel('ExampleRecordingName');
        $this->assertTrue(true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testStop(): void
    {
        $recordingsClient = $this->createRecordingsClientWithGuzzleClientStub([]);
        $recordingsClient->stop('ExampleRecordingName');
        $this->assertTrue(true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testPause(): void
    {
        $recordingsClient = $this->createRecordingsClientWithGuzzleClientStub([]);
        $recordingsClient->pause('ExampleRecordingName');
        $this->assertTrue(true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testUnpause(): void
    {
        $recordingsClient = $this->createRecordingsClientWithGuzzleClientStub([]);
        $recordingsClient->unpause('ExampleRecordingName');
        $this->assertTrue(true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testMute(): void
    {
        $recordingsClient = $this->createRecordingsClientWithGuzzleClientStub([]);
        $recordingsClient->mute('ExampleRecordingName');
        $this->assertTrue(true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testUnmute(): void
    {
        $recordingsClient = $this->createRecordingsClientWithGuzzleClientStub([]);
        $recordingsClient->unmute('ExampleRecordingName');
        $this->assertTrue(true);
    }

    /**
     * @param $expectedResponse
     * @return Recordings
     * @throws ReflectionException
     */
    private function createRecordingsClientWithGuzzleClientStub($expectedResponse): Recordings
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
        return new Recordings(
            new Settings('SomeUser', 'SomePw'),
            $guzzleClientStub
        );
    }
}
