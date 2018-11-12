<?php

/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\rabbitmq;

use function AriStasisApp\getShortClassName;
use function AriStasisApp\initLogger;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


class AsteriskEventPublisher
{
    /**
     * @var array
     */
    private $settings;

    /**
     * @var \Monolog\Logger
     */
    private $logger;

    /**
     * AsteriskEventPublisher constructor.
     * @param string $host
     * @param int $port
     * @param string $user
     * @param string $password
     * @param string $vhost
     */
    function __construct(
        string $host = 'localhost',
        int $port = 5672,
        string $user = 'guest',
        string $password = 'guest',
        string $vhost = '/'
        )
    {
        $this->settings = [$host, $port, $user, $password, $vhost];
        $this->logger = initLogger(getShortClassName($this));
    }

    /**
     * Publish messages to RabbitMQ
     *
     * @param array $body
     *
     * TODO: Is it possible to improve the performance by not opening/closing the connection every time we publish?
     */
    function publish(array $body)
    {
        // Setup RabbitMQ --------
        $exchange = 'asterisk';
        $queue = 'from-asterisk';
        $settings = $this->settings;
        // -----------------------

        $this->logger->debug("Connecting to RabbitMQ server...");
        $connection = new AMQPStreamConnection(
            $settings['host'], $settings['port'], $settings['user'], $settings['password'], $settings['vhost']);
        $channel = $connection->channel();

        $this->logger->debug("Declaring exchange/queue and binding queue...");
        $channel->queue_declare($queue, false, true, false, false);
        $channel->exchange_declare($exchange, 'direct', false, true, false);
        $channel->queue_bind($queue, $exchange);

        // TODO: Can we remove this?
        // Message handling starts here
        // $messageBody = implode(' ', array_slice($body,0));
        $this->logger->debug("Preparing to send body: {$body}");
        $message = new AMQPMessage(
            $body,
            array('content_type' => 'application/json', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT)
        );

        $channel->basic_publish($message, $exchange);
        $this->logger->debug("Message successfully published: {$message}");

        $channel->close();
        $connection->close();
    }
}