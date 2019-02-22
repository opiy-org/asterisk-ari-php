<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\models;


require_once __DIR__ . '/../../shared_test_functions.php';

use AriStasisApp\models\{messages\Message};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapMessage;

/**
 * Class MessageTest
 *
 * @package AriStasisApp\Tests\models\messages
 */
final class MessageTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
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