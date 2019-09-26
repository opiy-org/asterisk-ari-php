<?php

/** @copyright 2019 ng-voice GmbH */

namespace NgVoice\AriClient\Tests\RestClient;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use NgVoice\AriClient\Models\Application;
use NgVoice\AriClient\RestClient\{Applications, AriRestClientSettings};
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * Class ApplicationsTest
 *
 * @package NgVoice\AriClient\Tests\RestClient
 */
class ApplicationsTest extends TestCase
{
    /**
     * @return array
     */
    public function applicationInstanceProvider(): array
    {
        return [
            'example application' => [
                [
                    'name'              => 'TestApplication',
                    'channel_ids'       => [],
                    'endpoint_ids'      => [],
                    'bridge_ids'        => [],
                    'device_names'      => [],
                    'events_allowed'    => [],
                    'events_disallowed' => [],
                ],
            ],
        ];
    }

    /**
     * @dataProvider applicationInstanceProvider
     *
     * @param array $exampleApplication
     *
     * @throws ReflectionException
     * @throws AsteriskRestInterfaceException
     */
    public function testGet(array $exampleApplication): void
    {
        $applicationsClient =
            $this->createApplicationsClientWithGuzzleClientStub($exampleApplication);
        $resultChannel = $applicationsClient->get('12345');

        $this->assertInstanceOf(Application::class, $resultChannel);
    }

    /**
     * @dataProvider applicationInstanceProvider
     * @param array $exampleApplication
     *
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testUnsubscribe(array $exampleApplication): void
    {
        $applicationsClient =
            $this->createApplicationsClientWithGuzzleClientStub($exampleApplication);
        $resultApplication = $applicationsClient->unsubscribe('12345', []);

        $this->assertInstanceOf(Application::class, $resultApplication);
    }

    /**
     * @dataProvider applicationInstanceProvider
     * @param array $exampleApplication
     *
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testSubscribe(array $exampleApplication): void
    {
        $applicationsClient =
            $this->createApplicationsClientWithGuzzleClientStub($exampleApplication);
        $resultApplication = $applicationsClient->subscribe('12345', []);

        $this->assertInstanceOf(Application::class, $resultApplication);
    }

    /**
     * @dataProvider applicationInstanceProvider
     * @param string[] $exampleApplication
     *
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testList(array $exampleApplication): void
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
     *
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testFilter(array $exampleApplication): void
    {
        $applicationsClient =
            $this->createApplicationsClientWithGuzzleClientStub($exampleApplication);
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
     *
     * @return Applications
     *
     * @throws ReflectionException
     */
    private function createApplicationsClientWithGuzzleClientStub(
        $expectedResponse
    ): Applications {
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
        return new Applications(
            new AriRestClientSettings('SomeUser', 'SomePw'),
            $guzzleClientStub
        );
    }
}
