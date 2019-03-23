<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Model\{Endpoint, Message\EndpointStateChange};
use PHPUnit\Framework\TestCase;
use function NgVoice\AriClient\Tests\mapMessageParametersToAriObject;

/**
 * Class EndpointStateChangeTest
 *
 * @package NgVoice\AriClient\Tests\Model\Message
 */
final class EndpointStateChangeTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        $exampleEndpoint = [
            'state' => 'online',
            'technology' => 'ExampleTechnology',
            'channel_ids' => [
                'firstChannel',
                'secondChannel'
            ],
            'resource' => 'ExampleResource'
        ];

        /**
         * @var EndpointStateChange $endpointStateChange
         */
        $endpointStateChange = mapMessageParametersToAriObject(
            'EndpointStateChange',
            [
                'endpoint' => $exampleEndpoint
            ]
        );
        $this->assertInstanceOf(Endpoint::class, $endpointStateChange->getEndpoint());
    }
}