<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models;


use JsonMapper_Exception;
use NgVoice\AriClient\Models\Endpoint;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class EndpointTest
 *
 * @package NgVoice\AriClient\Tests\Models
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
        $endpoint = Helper::mapAriResponseParametersToAriObject(
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
