<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model\Message\Event;

use NgVoice\AriClient\Model\Endpoint;
use NgVoice\AriClient\Model\Message\Event\EndpointStateChange;
use NgVoice\AriClient\Tests\Helper;
use NgVoice\AriClient\Tests\Model\EndpointTest;
use PHPUnit\Framework\TestCase;

/**
 * Class EndpointStateChangeTest
 *
 * @package NgVoice\AriClient\Tests\Model\Event
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
