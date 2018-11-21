<?php

declare(strict_types=1);

namespace AriStasisApp\Tests\amqp;

use AriStasisApp\amqp\AMQPPublisher;
use PHPUnit\Framework\TestCase;


/**
 * Class AriAMQPPublisherTest
 *
 * @package AriStasisApp\Tests\amqp
 */
final class AriAMQPPublisherTest extends TestCase
{
    public function testCreateInstance(): void
    {
        $this->assertInstanceOf(AMQPPublisher::class, new AMQPPublisher());
    }
}