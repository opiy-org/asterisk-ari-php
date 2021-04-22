<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model\Message\Event;

use OpiyOrg\AriClient\Model\Channel;
use OpiyOrg\AriClient\Model\Message\Event\StasisEnd;
use OpiyOrg\AriClient\Tests\Helper;
use OpiyOrg\AriClient\Tests\Model\ChannelTest;
use PHPUnit\Framework\TestCase;

/**
 * Class StasisEndTest
 *
 * @package OpiyOrg\AriClient\Tests\Model\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class StasisEndTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var StasisEnd $stasisEnd
         */
        $stasisEnd = Helper::mapOntoAriEvent(
            StasisEnd::class,
            [
                'channel' => ChannelTest::RAW_ARRAY_REPRESENTATION,
            ]
        );
        $this->assertInstanceOf(Channel::class, $stasisEnd->getChannel());
    }
}
