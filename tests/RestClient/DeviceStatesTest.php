<?php

/** @copyright 2019 ng-voice GmbH */

namespace NgVoice\AriClient\Tests\RestClient;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use NgVoice\AriClient\Models\DeviceState;
use NgVoice\AriClient\RestClient\{AriRestClientSettings, DeviceStates};
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * Class SoundsTest
 * @package NgVoice\AriClient\Tests\RestClient
 */
class DeviceStatesTest extends TestCase
{
    /**
     * @return array
     */
    public function deviceStateInstanceProvider(): array
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
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testList(array $exampleDeviceState): void
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
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testGet(array $exampleDeviceState): void
    {
        $deviceStatesClient = $this->createDeviceStatesClient($exampleDeviceState);
        $resultDeviceState = $deviceStatesClient->get('12345');

        $this->assertInstanceOf(DeviceState::class, $resultDeviceState);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testDelete(): void
    {
        $deviceStatesClient = $this->createDeviceStatesClient([]);
        $deviceStatesClient->delete('SomeDeviceName');
        $this->assertTrue(true, true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testUpdate(): void
    {
        $deviceStatesClient = $this->createDeviceStatesClient([]);
        $deviceStatesClient->update('SomeDeviceName', 'NewState');
        $this->assertTrue(true, true);
    }

    /**
     * @param $expectedResponse
     * @return DeviceStates
     * @throws ReflectionException
     */
    private function createDeviceStatesClient($expectedResponse): DeviceStates
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
        return new DeviceStates(
            new AriRestClientSettings('SomeUser', 'SomePw'),
            $guzzleClientStub
        );
    }
}
