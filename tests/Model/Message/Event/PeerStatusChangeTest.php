<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model\Message\Event;

use NgVoice\AriClient\Model\Endpoint;
use NgVoice\AriClient\Model\Message\Event\PeerStatusChange;
use NgVoice\AriClient\Model\Peer;
use NgVoice\AriClient\Tests\Helper;
use NgVoice\AriClient\Tests\Model\EndpointTest;
use NgVoice\AriClient\Tests\Model\PeerTest;
use PHPUnit\Framework\TestCase;

/**
 * Class PeerStatusChangeTest
 *
 * @package NgVoice\AriClient\Tests\Model\Event
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
                'peer'     => PeerTest::RAW_ARRAY_REPRESENTATION,
                'endpoint' => EndpointTest::RAW_ARRAY_REPRESENTATION,
            ]
        );
        $this->assertInstanceOf(Endpoint::class, $peerStatusChange->getEndpoint());
        $this->assertInstanceOf(Peer::class, $peerStatusChange->getPeer());
    }
}
