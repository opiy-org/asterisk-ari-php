<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model;

use OpiyOrg\AriClient\Model\Endpoint;
use OpiyOrg\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class EndpointTest
 *
 * @package OpiyOrg\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class EndpointTest extends TestCase
{
    public const RAW_ARRAY_REPRESENTATION = [
        'state'       => 'online',
        'technology'  => 'ExampleTechnology',
        'channel_ids' => [
            'firstChannel',
            'secondChannel',
        ],
        'resource'    => 'ExampleResource',
    ];

    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var Endpoint $endpoint
         */
        $endpoint = Helper::mapOntoInstance(
            self::RAW_ARRAY_REPRESENTATION,
            new Endpoint()
        );
        $this->assertSame('online', $endpoint->getState());
        $this->assertSame('ExampleTechnology', $endpoint->getTechnology());
        $this->assertSame(['firstChannel', 'secondChannel'], $endpoint->getChannelIds());
        $this->assertSame('ExampleResource', $endpoint->getResource());
    }
}
