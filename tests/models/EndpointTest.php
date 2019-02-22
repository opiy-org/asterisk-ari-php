<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\models;


require_once __DIR__ . '/../shared_test_functions.php';

use AriStasisApp\models\{Endpoint};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapAriResponseParametersToAriObject;

/**
 * Class EndpointTest
 *
 * @package AriStasisApp\Tests\models
 */
final class EndpointTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
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