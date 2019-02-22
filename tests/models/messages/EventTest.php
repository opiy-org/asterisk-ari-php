<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\models;


require_once __DIR__ . '/../../shared_test_functions.php';

use AriStasisApp\models\{messages\Event};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapMessageParametersToAriObject;

/**
 * Class EventTest
 *
 * @package AriStasisApp\Tests\models\messages
 */
final class EventTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var Event $event
         */
        $event = mapMessageParametersToAriObject(
            'Event',
            [
                'timestamp' => '2016-12-20 13:45:28 UTC',
                'application' => 'ExampleApp'
            ]
        );
        $this->assertSame('ExampleApp', $event->getApplication());
        $this->assertSame('2016-12-20 13:45:28 UTC', $event->getTimestamp());
    }
}