<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model\Message\Event;

use OpiyOrg\AriClient\Model\Endpoint;
use OpiyOrg\AriClient\Model\Message\Event\PeerStatusChange;
use OpiyOrg\AriClient\Model\Peer;
use OpiyOrg\AriClient\Tests\Helper;
use OpiyOrg\AriClient\Tests\Model\EndpointTest;
use OpiyOrg\AriClient\Tests\Model\PeerTest;
use PHPUnit\Framework\TestCase;

/**
 * Class PeerStatusChangeTest
 *
 * @package OpiyOrg\AriClient\Tests\Model\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class PeerStatusChangeTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var PeerStatusChange $peerStatusChange
         */
        $peerStatusChange = Helper::mapOntoAriEvent(
            PeerStatusChange::class,
            [
                'peer' => PeerTest::RAW_ARRAY_REPRESENTATION,
                'endpoint' => EndpointTest::RAW_ARRAY_REPRESENTATION,
            ]
        );
        $this->assertInstanceOf(Endpoint::class, $peerStatusChange->getEndpoint());
        $this->assertInstanceOf(Peer::class, $peerStatusChange->getPeer());
    }
}
