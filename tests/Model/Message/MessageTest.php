<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model\Message;

use OpiyOrg\AriClient\Model\Message\Message;
use OpiyOrg\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class MessageTest
 *
 * @package OpiyOrg\AriClient\Tests\Model\Message
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class MessageTest extends TestCase
{
    public const RAW_ARRAY_REPRESENTATION = [
        'type'        => 'SomeType',
        'asterisk_id' => '1224235346.2333',
    ];

    private Message $message;

    public function setUp(): void
    {
        $this->message = new Message();
    }

    public function testCreate(): void
    {
        $this->assertInstanceOf(Message::class, $this->message);
    }

    public function testSetAndGetAsteriskId(): void
    {
        Helper::mapOntoInstance(self::RAW_ARRAY_REPRESENTATION, $this->message);

        $this->assertSame('1224235346.2333', $this->message->getAsteriskId());
    }

    public function testSetAndGetType(): void
    {
        Helper::mapOntoInstance(self::RAW_ARRAY_REPRESENTATION, $this->message);

        $this->assertSame('SomeType', $this->message->getType());
    }
}
