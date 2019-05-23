<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Models\{Endpoint, Message\EndpointStateChange};
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class EndpointStateChangeTest
 *
 * @package NgVoice\AriClient\Tests\Models\Message
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
        $endpointStateChange = Helper::mapMessageParametersToAriObject(
            'EndpointStateChange',
            [
                'endpoint' => $exampleEndpoint
            ]
        );
        $this->assertInstanceOf(Endpoint::class, $endpointStateChange->getEndpoint());
    }
}
