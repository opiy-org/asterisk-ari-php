<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\Tests\RestClient;

use AriStasisApp\Model\{DeviceState};
use AriStasisApp\RestClient\DeviceStates;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * Class SoundsTest
 * @package AriStasisApp\Tests\RestClient
 */
class DeviceStatesTest extends TestCase
{
    /**
     * @return array
     */
    public function deviceStateInstanceProvider()
    {
        return [
            'example device state' => [
                [
                    'state' => 'BUSY',
                    'name' => 'ExampleName',
                ]
            ]
        ];
    }

    /**
     * @dataProvider deviceStateInstanceProvider
     * @param array $exampleDeviceState
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testList(array $exampleDeviceState)
    {
        $deviceStatesClient = $this->createDeviceStatesClient(
            [$exampleDeviceState, $exampleDeviceState, $exampleDeviceState]
        );
        $resultList = $deviceStatesClient->list();

        $this->assertIsArray($resultList);
        foreach ($resultList as $resultDeviceState) {
            $this->assertInstanceOf(DeviceState::class, $resultDeviceState);
        }
    }

    /**
     * @dataProvider deviceStateInstanceProvider
     * @param string[] $exampleDeviceState
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testGet(array $exampleDeviceState)
    {
        $deviceStatesClient = $this->createDeviceStatesClient($exampleDeviceState);
        $resultDeviceState = $deviceStatesClient->get('12345');

        $this->assertInstanceOf(DeviceState::class, $resultDeviceState);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testDelete()
    {
        $deviceStatesClient = $this->createDeviceStatesClient([]);
        $deviceStatesClient->delete('SomeDeviceName');
        $this->assertTrue(true, true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testUpdate()
    {
        $deviceStatesClient = $this->createDeviceStatesClient([]);
        $deviceStatesClient->update('SomeDeviceName', 'NewState');
        $this->assertTrue(true, true);
    }

    /**
     * @param $expectedResponse
     * @return DeviceStates
     * @throws \ReflectionException
     */
    private function createDeviceStatesClient($expectedResponse)
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
        return new DeviceStates('SomeUser', 'SomePw', [], $guzzleClientStub);
    }
}
