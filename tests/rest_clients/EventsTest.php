<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\rest_clients;


use AriStasisApp\rest_clients\Events;
use PHPUnit\Framework\TestCase;

/**
 * Class EventsTest
 *
 * @package AriStasisApp\Tests\http_client
 */
final class EventsTest extends TestCase
{
    /**
     *
     */
    public function testCreateInstance(): void
    {
        $this->assertInstanceOf(Events::class, new Events('asterisk','asterisk'));
    }
}