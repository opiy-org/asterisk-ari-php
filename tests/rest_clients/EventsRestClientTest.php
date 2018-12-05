<?php

declare(strict_types=1);

namespace AriStasisApp\Tests\rest_clients;


use AriStasisApp\rest_clients\Events;
use PHPUnit\Framework\TestCase;

/**
 * Class EventsRestClientTest
 *
 * @package AriStasisApp\Tests\http_client
 */
final class EventsRestClientTest extends TestCase
{
    public function testCreateInstance(): void
    {
        $this->assertInstanceOf(Events::class, new Events('asterisk','asterisk'));
    }

    public function testQueryParameters(): void
    {
        $this->assertContains(true, true);
    }
}