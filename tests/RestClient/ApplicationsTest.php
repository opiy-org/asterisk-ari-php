<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */


namespace AriStasisApp\Tests\RestClient;

use AriStasisApp\Model\Application;
use AriStasisApp\RestClient\Applications;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * Class ApplicationsTest
 * @package AriStasisApp\Tests\RestClient
 */
class ApplicationsTest extends TestCase
{
    /**
     * @return array
     */
    public function applicationInstanceProvider()
    {
        return [
            'example application' => [
                [
                    'name' => 'TestApplication',
                    'channel_ids' => [],
                    'endpoint_ids' => [],
                    'bridge_ids' => [],
                    'device_names' => [],
                    'events_allowed' => [],
                    'events_disallowed' => []
                ]
            ],
        ];
    }

    /**
     * @dataProvider applicationInstanceProvider
     * @param array $exampleApplication
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testGet(array $exampleApplication)
    {
        $applicationsClient = $this->createApplicationsClientWithGuzzleClientStub($exampleApplication);
        $resultChannel = $applicationsClient->get('12345');

        $this->assertInstanceOf(Application::class, $resultChannel);
    }

    /**
     * @dataProvider applicationInstanceProvider
     * @param array $exampleApplication
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testUnsubscribe(array $exampleApplication)
    {
        $applicationsClient = $this->createApplicationsClientWithGuzzleClientStub($exampleApplication);
        $resultApplication = $applicationsClient->unsubscribe('12345', []);

        $this->assertInstanceOf(Application::class, $resultApplication);
    }

    /**
     * @dataProvider applicationInstanceProvider
     * @param array $exampleApplication
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testSubscribe(array $exampleApplication)
    {
        $applicationsClient = $this->createApplicationsClientWithGuzzleClientStub($exampleApplication);
        $resultApplication = $applicationsClient->subscribe('12345', []);

        $this->assertInstanceOf(Application::class, $resultApplication);
    }

    /**
     * @dataProvider applicationInstanceProvider
     * @param string[] $exampleApplication
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testList(array $exampleApplication)
    {
        $applicationsClient = $this->createApplicationsClientWithGuzzleClientStub(
            [$exampleApplication, $exampleApplication, $exampleApplication]
        );
        $resultList = $applicationsClient->list();

        $this->assertIsArray($resultList);
        foreach ($resultList as $resultApplication) {
            $this->assertInstanceOf(Application::class, $resultApplication);
        }
    }

    /**
     * @dataProvider applicationInstanceProvider
     * @param array $exampleApplication
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testFilter(array $exampleApplication)
    {
        $applicationsClient = $this->createApplicationsClientWithGuzzleClientStub($exampleApplication);
        $resultApplication = $applicationsClient->filter('12345');
        $this->assertInstanceOf(Application::class, $resultApplication);
        $resultApplication1 = $applicationsClient->filter(
            '12345',
            ['BridgeDestroyed', 'BridgeCreated'],
            ['BridgeMerged', 'ChannelCreated']
        );
        $this->assertInstanceOf(Application::class, $resultApplication1);


    }

    /**
     * @param $expectedResponse
     * @return Applications
     * @throws \ReflectionException
     */
    private function createApplicationsClientWithGuzzleClientStub($expectedResponse)
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
        return new Applications('SomeUser', 'SomePw', [], $guzzleClientStub);
    }
}
