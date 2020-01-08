<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace AriStasisApp\Tests\Model;

use NgVoice\AriClient\Model\{AsteriskPing};
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class AsteriskPingTest
 *
 * @package AriStasisApp\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class AsteriskPingTest extends TestCase
{
    private const RAW_ARRAY_REPRESENTATION = [
        'timestamp'   => 'someTimestamp',
        'ping'        => 'pong',
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
        Helper::mapOntoInstance(self::RAW_ARRAY_REPRESENTATION, $this->asteriskPing);

        $this->assertSame('someTimestamp', $this->asteriskPing->getTimestamp());
    }

    public function testSetAndGetPing(): void
    {
        Helper::mapOntoInstance(self::RAW_ARRAY_REPRESENTATION, $this->asteriskPing);

        $this->assertSame('pong', $this->asteriskPing->getPing());
    }

    public function testSetAndGetAsteriskId(): void
    {
        Helper::mapOntoInstance(self::RAW_ARRAY_REPRESENTATION, $this->asteriskPing);

        $this->assertSame('asteriskId', $this->asteriskPing->getAsteriskId());
    }
}
