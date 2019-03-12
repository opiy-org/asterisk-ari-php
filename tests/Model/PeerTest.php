<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\Model;


require_once __DIR__ . '/../shared_test_functions.php';

use AriStasisApp\Model\{Peer};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapAriResponseParametersToAriObject;

/**
 * Class PeerTest
 *
 * @package AriStasisApp\Tests\Model
 */
final class PeerTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var Peer $peer
         */
        $peer = mapAriResponseParametersToAriObject(
            'Peer',
            [
                'peer_status' => 'Up',
                'time' => '2016-12-20 13:45:28 UTC',
                'cause' => 'The reason for everything!',
                'port' => '8000',
                'address' => '172.0.0.1'
            ]
        );
        $this->assertSame('The reason for everything!', $peer->getCause());
        $this->assertSame('172.0.0.1', $peer->getAddress());
        $this->assertSame('Up', $peer->getPeerStatus());
        $this->assertSame('8000', $peer->getPort());
        $this->assertSame('2016-12-20 13:45:28 UTC', $peer->getTime());
    }
}