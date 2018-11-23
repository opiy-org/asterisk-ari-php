<?php

declare(strict_types=1);

namespace AriStasisApp\Tests\amqp;

use AriStasisApp\amqp\AMQPPublisher;
use PHPUnit\Framework\TestCase;


/**
 * Class AMQPPublisherTest
 *
 * @package AriStasisApp\Tests\amqp
 */
final class AMQPPublisherTest extends TestCase
{
    public function testCreateInstance(): void
    {
        $this->assertInstanceOf(AMQPPublisher::class, new AMQPPublisher());
    }
}