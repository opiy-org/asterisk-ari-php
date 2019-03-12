<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\Model;


require_once __DIR__ . '/../../shared_test_functions.php';

use AriStasisApp\Model\{Endpoint, Message\PeerStatusChange, Peer};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapMessageParametersToAriObject;

/**
 * Class PeerStatusChangeTest
 *
 * @package AriStasisApp\Tests\Model\Message
 */
final class PeerStatusChangeTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
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
        $peerStatusChange = mapMessageParametersToAriObject(
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