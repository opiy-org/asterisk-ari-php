<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Models\{Message\Message};
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class MessageTest
 *
 * @package NgVoice\AriClient\Tests\Models\Message
 */
final class MessageTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var Message $message
         */
        $message = Helper::mapMessage();
        $this->assertSame('856134087103571', $message->getAsteriskId());
        $this->assertSame('ExampleType', $message->getType());
    }
}
