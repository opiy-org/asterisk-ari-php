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

namespace OpiyOrg\AriClient\Tests\Model\Message\Event;

use OpiyOrg\AriClient\Model\Channel;
use OpiyOrg\AriClient\Model\Message\Event\ChannelCallerId;
use OpiyOrg\AriClient\Tests\Helper;
use OpiyOrg\AriClient\Tests\Model\ChannelTest;
use PHPUnit\Framework\TestCase;

/**
 * Class ChannelCallerIdTest
 *
 * @package OpiyOrg\AriClient\Tests\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ChannelCallerIdTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var ChannelCallerId $channelCallerId
         */
        $channelCallerId = Helper::mapOntoAriEvent(
            ChannelCallerId::class,
            [
                'channel' => ChannelTest::RAW_ARRAY_REPRESENTATION,
                'caller_presentation' => 15,
                'caller_presentation_txt' => 'SomeTxt',
            ]
        );
        $this->assertInstanceOf(Channel::class, $channelCallerId->getChannel());
        $this->assertSame(15, $channelCallerId->getCallerPresentation());
        $this->assertSame('SomeTxt', $channelCallerId->getCallerPresentationTxt());
    }
}
