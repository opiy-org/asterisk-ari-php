<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\Tests\RestClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use NgVoice\AriClient\RestClient\Events;
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * Class EventsTest
 * @package NgVoice\AriClient\Tests\RestClient
 */
class EventsTest extends TestCase
{

    /**
     * @throws GuzzleException
     * @throws ReflectionException
     */
    public function testUserEvent(): void
    {
        $eventsClient = $this->createEventsClientWithGuzzleClientStub([]);
        $eventsClient->userEvent(
            'ExampleEvent',
            'ExampleApp',
            ['SourceType1' => 'ExampleSource', 'SourceType2' => 'ExampleSource1', 'SourceType3' => 'ExampleSource2'],
            ['var1' => 'val1', 'var2' => 'val2', 'var3' => 'val3']
        );
        $this->assertTrue(true, true);
    }

    /**
     * @param $expectedResponse
     * @return Events
     * @throws \ReflectionException
     */
    private function createEventsClientWithGuzzleClientStub($expectedResponse): Events
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
        return new Events('SomeUser', 'SomePw', [], $guzzleClientStub);
    }
}
