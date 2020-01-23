<?php

/** @copyright 2020 ng-voice GmbH */

namespace NgVoice\AriClient\Tests\Client\Rest\ResourceClient;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use NgVoice\AriClient\Client\Rest\Resource\Applications;
use NgVoice\AriClient\Client\Rest\Settings;
use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use NgVoice\AriClient\Model\Application;
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * Class ApplicationsTest
 *
 * @package NgVoice\AriClient\Tests\Rest
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class ApplicationsTest extends TestCase
{
    public const EXAMPLE = [
        'name'              => 'TestApplication',
        'channel_ids'       => [],
        'endpoint_ids'      => [],
        'bridge_ids'        => [],
        'device_names'      => [],
        'events_allowed'    => [],
        'events_disallowed' => [],
    ];

    /**
     *
     * @throws ReflectionException
     * @throws AsteriskRestInterfaceException
     */
    public function testGet(): void
    {
        $applicationsClient =
            $this->createApplicationsClientWithGuzzleClientStub(self::EXAMPLE);
        $resultChannel = $applicationsClient->get('12345');

        $this->assertInstanceOf(Application::class, $resultChannel);
    }

    /**
     *
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testUnsubscribe(): void
    {
        $applicationsClient =
            $this->createApplicationsClientWithGuzzleClientStub(self::EXAMPLE);
        $resultApplication = $applicationsClient->unsubscribe('12345', []);

        $this->assertInstanceOf(Application::class, $resultApplication);
    }

    /**
     *
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testSubscribe(): void
    {
        $applicationsClient =
            $this->createApplicationsClientWithGuzzleClientStub(self::EXAMPLE);
        $resultApplication = $applicationsClient->subscribe('12345', []);

        $this->assertInstanceOf(Application::class, $resultApplication);
    }

    /**
     *
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testList(): void
    {
        $applicationsClient = $this->createApplicationsClientWithGuzzleClientStub(
            [self::EXAMPLE, self::EXAMPLE, self::EXAMPLE]
        );
        $resultList = $applicationsClient->list();

        $this->assertIsArray($resultList);
        foreach ($resultList as $resultApplication) {
            $this->assertInstanceOf(Application::class, $resultApplication);
        }
    }

    /**
     *
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testFilter(): void
    {
        $applicationsClient =
            $this->createApplicationsClientWithGuzzleClientStub(self::EXAMPLE);
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

        $settings = new Settings('SomeUser', 'SomePw');

        /**
         * @var Client $guzzleClientStub
         */
        return new Applications(
            $settings,
            $guzzleClientStub
        );
    }
}
