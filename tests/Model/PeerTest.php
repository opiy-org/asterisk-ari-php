<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model;

use OpiyOrg\AriClient\Model\Peer;
use OpiyOrg\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class PeerTest
 *
 * @package OpiyOrg\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class PeerTest extends TestCase
{
    public const RAW_ARRAY_REPRESENTATION = [
        'peer_status' => 'Up',
        'time' => '2016-12-20 13:45:28 UTC',
        'cause' => 'The reason for everything!',
        'port' => '8000',
        'address' => '172.0.0.1',
    ];

    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var Peer $peer
         */
        $peer = Helper::mapOntoInstance(
            self::RAW_ARRAY_REPRESENTATION,
            new Peer()
        );
        $this->assertSame('The reason for everything!', $peer->getCause());
        $this->assertSame('172.0.0.1', $peer->getAddress());
        $this->assertSame('Up', $peer->getPeerStatus());
        $this->assertSame('8000', $peer->getPort());
        $this->assertSame('2016-12-20 13:45:28 UTC', $peer->getTime());
    }
}
