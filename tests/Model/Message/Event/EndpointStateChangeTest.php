<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model\Message\Event;

use OpiyOrg\AriClient\Model\Endpoint;
use OpiyOrg\AriClient\Model\Message\Event\EndpointStateChange;
use OpiyOrg\AriClient\Tests\Helper;
use OpiyOrg\AriClient\Tests\Model\EndpointTest;
use PHPUnit\Framework\TestCase;

/**
 * Class EndpointStateChangeTest
 *
 * @package OpiyOrg\AriClient\Tests\Model\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class EndpointStateChangeTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var EndpointStateChange $endpointStateChange
         */
        $endpointStateChange = Helper::mapOntoAriEvent(
            EndpointStateChange::class,
            [
                'endpoint' => EndpointTest::RAW_ARRAY_REPRESENTATION,
            ]
        );
        $this->assertInstanceOf(Endpoint::class, $endpointStateChange->getEndpoint());
    }
}
