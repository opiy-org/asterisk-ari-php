<?php

/**
 * @copyright 2020 ng-voice GmbH
 *
 * @noinspection UnknownInspectionInspection The [EA] plugin for PhpStorm doesn't know
 * about the noinspection annotation.
 * @noinspection ClassMockingCorrectnessInspection We are using a dependency to hook
 * onto classes before the tests in order to remove the 'final' class keyword. This makes
 * the classes extendable for PhpUnit and therefore testable.
 */

declare(strict_types=1);

namespace AriClient\Tests\Model;

use NgVoice\AriClient\Model\Channel;
use NgVoice\AriClient\Model\Message\Event\ChannelDestroyed;
use NgVoice\AriClient\Tests\Helper;
use NgVoice\AriClient\Tests\Model\ChannelTest;
use PHPUnit\Framework\TestCase;

/**
 * Class ChannelDestroyedTest
 *
 * @package NgVoice\AriClient\Tests\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ChannelDestroyedTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var ChannelDestroyed $channelDestroyed
         */
        $channelDestroyed = Helper::mapOntoAriEvent(
            ChannelDestroyed::class,
            [
                'cause'     => 23,
                'cause_txt' => 'SomeCauseTxt',
                'channel'   => ChannelTest::RAW_ARRAY_REPRESENTATION,
            ]
        );
        $this->assertInstanceOf(Channel::class, $channelDestroyed->getChannel());
        $this->assertSame(23, $channelDestroyed->getCause());
        $this->assertSame('SomeCauseTxt', $channelDestroyed->getCauseTxt());
    }
}
