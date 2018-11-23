<?php

declare(strict_types=1);

namespace AriStasisApp\Tests\http_client;

use AriStasisApp\http_client\EventsRestClient;
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
        $this->assertInstanceOf(EventsRestClient::class, new EventsRestClient());
    }

    public function testQueryParameters(): void
    {
        $this->assertContains(true, true);
    }
}