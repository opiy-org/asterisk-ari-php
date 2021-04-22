<?php

/** @copyright 2020 ng-voice GmbH */

namespace OpiyOrg\AriClient\Tests\Client\Rest;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use OpiyOrg\AriClient\Client\Rest\Resource\Events;
use OpiyOrg\AriClient\Client\Rest\Settings;
use OpiyOrg\AriClient\Exception\AsteriskRestInterfaceException;
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * Class EventsTest
 *
 * @package OpiyOrg\AriClient\Tests\Rest
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class EventsTest extends TestCase
{
    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testUserEvent(): void
    {
        $eventsClient = $this->createEventsClientWithGuzzleClientStub([]);
        $eventsClient->userEvent(
            'ExampleEvent',
            'MyExampleStasisApp',
            ['SourceType1' => 'ExampleSource', 'SourceType2' => 'ExampleSource1', 'SourceType3' => 'ExampleSource2'],
            ['var1' => 'val1', 'var2' => 'val2', 'var3' => 'val3']
        );
        $this->assertTrue(true, true);
    }

    /**
     * @param $expectedResponse
     * @return Events
     * @throws ReflectionException
     */
    private function createEventsClientWithGuzzleClientStub($expectedResponse): Events
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
        return new Events(
            new Settings('SomeUser', 'SomePw'),
            $guzzleClientStub
        );
    }
}
