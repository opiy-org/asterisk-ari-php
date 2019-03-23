<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\Tests\RestClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use NgVoice\AriClient\Model\Sound;
use NgVoice\AriClient\RestClient\Sounds;
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * Class SoundsTest
 * @package NgVoice\AriClient\Tests\RestClient
 */
class SoundsTest extends TestCase
{
    /**
     * @return array
     */
    public function soundInstanceProvider(): array
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
     * @throws GuzzleException
     * @throws ReflectionException
     */
    public function testList(array $exampleSound): void
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
    public function testGet(array $exampleSound): void
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
    private function createSoundsClient($expectedResponse): Sounds
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
