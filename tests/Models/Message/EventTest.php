<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models\Message;


use JsonMapper_Exception;
use NgVoice\AriClient\Models\{Message\Event};
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class EventTest
 *
 * @package NgVoice\AriClient\Tests\Models\Message
 */
final class EventTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var Event $event
         */
        $event = Helper::mapMessageParametersToAriObject(
            'Event',
            [
                'timestamp' => '2016-12-20 13:45:28 UTC',
                'application' => 'MyExampleStasisApp'
            ]
        );
        $this->assertSame('MyExampleStasisApp', $event->getApplication());
        $this->assertSame('2016-12-20 13:45:28 UTC', $event->getTimestamp());
    }
}
