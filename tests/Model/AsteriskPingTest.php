<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model;

use OpiyOrg\AriClient\Model\{AsteriskPing};
use OpiyOrg\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class AsteriskPingTest
 *
 * @package OpiyOrg\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class AsteriskPingTest extends TestCase
{
    private const RAW_ARRAY_REPRESENTATION = [
        'timestamp' => 'someTimestamp',
        'ping' => 'pong',
        'asterisk_id' => 'asteriskId',
    ];

    private AsteriskPing $asteriskPing;

    public function setUp(): void
    {
        $this->asteriskPing = new AsteriskPing();
    }

    public function testCreate(): void
    {
        $this->assertInstanceOf(AsteriskPing::class, $this->asteriskPing);
    }

    public function testSetAndGetTimestamp(): void
    {
        $this->asteriskPing = Helper::mapOntoInstance(self::RAW_ARRAY_REPRESENTATION, $this->asteriskPing);

        $this->assertSame('someTimestamp', $this->asteriskPing->getTimestamp());
    }

    public function testSetAndGetPing(): void
    {
        $this->asteriskPing = Helper::mapOntoInstance(self::RAW_ARRAY_REPRESENTATION, $this->asteriskPing);

        $this->assertSame('pong', $this->asteriskPing->getPing());
    }

    public function testSetAndGetAsteriskId(): void
    {
        $this->asteriskPing = Helper::mapOntoInstance(self::RAW_ARRAY_REPRESENTATION, $this->asteriskPing);

        $this->assertSame('asteriskId', $this->asteriskPing->getAsteriskId());
    }
}
