<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model\Message\Event;

use NgVoice\AriClient\Model\Channel;
use NgVoice\AriClient\Model\Message\Event\Dial;
use NgVoice\AriClient\Tests\Helper;
use NgVoice\AriClient\Tests\Model\ChannelTest;
use PHPUnit\Framework\TestCase;

/**
 * Class DialTest
 *
 * @package NgVoice\AriClient\Tests\Model\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class DialTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var Dial $dial
         */
        $dial = Helper::mapOntoAriEvent(
            Dial::class,
            [
                'forwarded'  => ChannelTest::RAW_ARRAY_REPRESENTATION,
                'caller'     => ChannelTest::RAW_ARRAY_REPRESENTATION,
                'dialstatus' => 'DialStatus',
                'forward'    => 'Forward',
                'dialstring' => 'Dialstring',
                'peer'       => ChannelTest::RAW_ARRAY_REPRESENTATION,
            ]
        );
        $this->assertInstanceOf(Channel::class, $dial->getForwarded());
        $this->assertInstanceOf(Channel::class, $dial->getCaller());
        $this->assertSame('DialStatus', $dial->getDialstatus());
        $this->assertSame('Forward', $dial->getForward());
        $this->assertSame('Dialstring', $dial->getDialstring());
        $this->assertInstanceOf(Channel::class, $dial->getPeer());
    }
}
