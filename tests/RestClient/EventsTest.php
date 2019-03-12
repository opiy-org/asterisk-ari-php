<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\Tests\RestClient;

use AriStasisApp\RestClient\Events;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class EventsTest extends TestCase
{

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testUserEvent()
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
    private function createEventsClientWithGuzzleClientStub($expectedResponse)
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
