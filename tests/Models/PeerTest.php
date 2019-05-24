<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models;


use JsonMapper_Exception;
use NgVoice\AriClient\Models\Peer;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class PeerTest
 *
 * @package NgVoice\AriClient\Tests\Models
 */
final class PeerTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var Peer $peer
         */
        $peer = Helper::mapAriResponseParametersToAriObject(
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
