<?php

/** @copyright 2019 ng-voice GmbH */

namespace NgVoice\AriClient\Tests\RestClient\ResourceClient;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use NgVoice\AriClient\Models\{Endpoint};
use NgVoice\AriClient\RestClient\ResourceClient\Endpoints;
use NgVoice\AriClient\RestClient\Settings;
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * Class SoundsTest
 *
 * @package NgVoice\AriClient\Tests\RestClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class EndpointsTest extends TestCase
{
    /**
     * @return array
     */
    public function endpointInstanceProvider(): array
    {
        return [
            'example endpoint' => [
                [
                    'state' => 'online',
                    'technology' => 'ExampleTechnology',
                    'channel_ids' => [
                        'firstChannel',
                        'secondChannel'
                    ],
                    'resource' => 'ExampleResource'
                ]
            ]
        ];
    }

    /**
     * @dataProvider endpointInstanceProvider
     * @param array $exampleEndpoint
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testList(array $exampleEndpoint): void
    {
        $endpointsClient = $this->createEndpointsClient(
            [$exampleEndpoint, $exampleEndpoint, $exampleEndpoint]
        );
        $resultList = $endpointsClient->list();

        $this->assertIsArray($resultList);
        foreach ($resultList as $resultEndpoint) {
            $this->assertInstanceOf(Endpoint::class, $resultEndpoint);
        }
    }

    /**
     * @dataProvider endpointInstanceProvider
     * @param array $exampleEndpoint
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testListByTech(array $exampleEndpoint): void
    {
        $endpointsClient = $this->createEndpointsClient(
            [$exampleEndpoint, $exampleEndpoint, $exampleEndpoint]
        );
        $resultList = $endpointsClient->listByTech('SomeTech');

        $this->assertIsArray($resultList);
        foreach ($resultList as $resultEndpoint) {
            $this->assertInstanceOf(Endpoint::class, $resultEndpoint);
        }
    }

    /**
     * @dataProvider endpointInstanceProvider
     * @param string[] $exampleEndpoint
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testGet(array $exampleEndpoint): void
    {
        $endpointsClient = $this->createEndpointsClient($exampleEndpoint);
        $resultEndpoint = $endpointsClient->get('12345', 'ExampleResource');

        $this->assertInstanceOf(Endpoint::class, $resultEndpoint);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testSendMessage(): void
    {
        $endpointsClient = $this->createEndpointsClient([]);
        $endpointsClient->sendMessage('Stefan', 'Lukas', 'This is a message for you.');
        $this->assertTrue(true, true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testSendMessageToEndpoint(): void
    {
        $endpointsClient = $this->createEndpointsClient([]);
        $endpointsClient->sendMessageToEndpoint('SomeTech', 'ExampleResource', 'This is a message.');
        $this->assertTrue(true, true);
    }

    /**
     * @param $expectedResponse
     * @return Endpoints
     * @throws ReflectionException
     */
    private function createEndpointsClient($expectedResponse): Endpoints
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
        return new Endpoints(
            new Settings('SomeUser', 'SomePw'),
            $guzzleClientStub
        );
    }
}
