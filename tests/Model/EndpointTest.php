<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Model\Endpoint;
use PHPUnit\Framework\TestCase;
use function NgVoice\AriClient\Tests\mapAriResponseParametersToAriObject;

/**
 * Class EndpointTest
 *
 * @package NgVoice\AriClient\Tests\Model
 */
final class EndpointTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var Endpoint $endpoint
         */
        $endpoint = mapAriResponseParametersToAriObject(
            'Endpoint',
            [
                'state' => 'online',
                'technology' => 'ExampleTechnology',
                'channel_ids' => [
                    'firstChannel',
                    'secondChannel'
                ],
                'resource' => 'ExampleResource'
            ]
        );
        $this->assertSame('online', $endpoint->getState());
        $this->assertSame('ExampleTechnology', $endpoint->getTechnology());
        $this->assertSame(['firstChannel', 'secondChannel'], $endpoint->getChannelIds());
        $this->assertSame('ExampleResource', $endpoint->getResource());
    }
}