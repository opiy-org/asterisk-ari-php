<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Model\{Message\Message};
use PHPUnit\Framework\TestCase;
use function NgVoice\AriClient\Tests\mapMessage;

/**
 * Class MessageTest
 *
 * @package NgVoice\AriClient\Tests\Model\Message
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
        $message = mapMessage();
        $this->assertSame('856134087103571', $message->getAsteriskId());
        $this->assertSame('ExampleType', $message->getType());
    }
}