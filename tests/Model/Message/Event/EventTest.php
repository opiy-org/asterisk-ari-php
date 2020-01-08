<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model\Message\Event;

use NgVoice\AriClient\Model\Message\Event\Event;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class EventTest
 *
 * @package NgVoice\AriClient\Tests\Model\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class EventTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var Event $event
         */
        $event = Helper::mapOntoAriEvent(
            Event::class,
            [
                'timestamp'   => '2016-12-20 13:45:28 UTC',
                'application' => 'someApplication',
            ]
        );
        $this->assertSame('someApplication', $event->getApplication());
        $this->assertSame('2016-12-20 13:45:28 UTC', $event->getTimestamp());
    }
}
