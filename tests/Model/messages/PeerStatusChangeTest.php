<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Models\{Endpoint, Message\PeerStatusChange, Peer};
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class PeerStatusChangeTest
 *
 * @package NgVoice\AriClient\Tests\Models\Message
 */
final class PeerStatusChangeTest extends TestCase
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

        $examplePeer = [
            'peer_status' => 'Up',
            'time' => '2016-12-20 13:45:28 UTC',
            'cause' => 'The reason for everything!',
            'port' => '8000',
            'address' => '172.0.0.1'
        ];

        /**
         * @var PeerStatusChange $peerStatusChange
         */
        $peerStatusChange = Helper::mapMessageParametersToAriObject(
            'PeerStatusChange',
            [
                'peer' => $examplePeer,
                'endpoint' => $exampleEndpoint
            ]
        );
        $this->assertInstanceOf(Endpoint::class, $peerStatusChange->getEndpoint());
        $this->assertInstanceOf(Peer::class, $peerStatusChange->getPeer());
    }
}
