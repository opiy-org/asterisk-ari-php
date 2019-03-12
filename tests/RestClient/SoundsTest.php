<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\Tests\RestClient;

use AriStasisApp\Model\{Sound};
use AriStasisApp\RestClient\Sounds;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * Class SoundsTest
 * @package AriStasisApp\Tests\RestClient
 */
class SoundsTest extends TestCase
{
    /**
     * @return array
     */
    public function soundInstanceProvider()
    {
        return [
            'example sound' => [
                [
                    'id' => 'ExampleId',
                    'formats' => [
                        [
                            'format' => 'X',
                            'language' => 'Y'
                        ]
                    ],
                    'text' => 'ExampleText'
                ]
            ]
        ];
    }

    /**
     * @dataProvider soundInstanceProvider
     * @param array $exampleSound
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testList(array $exampleSound)
    {
        $soundsClient = $this->createSoundsClient(
            [$exampleSound, $exampleSound, $exampleSound]
        );
        $resultList = $soundsClient->list();

        $this->assertIsArray($resultList);
        foreach ($resultList as $resultSound) {
            $this->assertInstanceOf(Sound::class, $resultSound);
        }
    }

    /**
     * @dataProvider soundInstanceProvider
     * @param string[] $exampleSound
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testGet(array $exampleSound)
    {
        $soundsClient = $this->createSoundsClient($exampleSound);
        $resultSound = $soundsClient->get('12345');

        $this->assertInstanceOf(Sound::class, $resultSound);
    }

    /**
     * @param $expectedResponse
     * @return Sounds
     * @throws \ReflectionException
     */
    private function createSoundsClient($expectedResponse)
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
        return new Sounds('SomeUser', 'SomePw', [], $guzzleClientStub);
    }
}
