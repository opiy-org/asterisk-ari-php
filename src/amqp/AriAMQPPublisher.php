<?php

/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\amqp;

use function AriStasisApp\{getShortClassName, initLogger};
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


class AriAMQPPublisher
{
    /**
     * @var \Monolog\Logger
     */
    private $logger;

    /**
     * @var AMQPStreamConnection
     */
    private $connection;

    /**
     * @var \PhpAmqpLib\Channel\AMQPChannel
     */
    private $channel;

    /**
     * @var string
     */
    private $exchanger;

    /**
     * AriAMQPPublisher constructor.
     *
     * The default values are for RabbitMQ but you can choose whatever implements the AMQP protocol!
     *
     * @param string $appName
     * @param string $host
     * @param int $port
     * @param string $user
     * @param string $password
     * @param string $vhost
     * @param string $exchanger
     */
    function __construct(
        string $appName = '',
        string $host = 'localhost',
        int $port = 5672,
        string $user = 'guest',
        string $password = 'guest',
        string $vhost = '/',
        string $exchanger = 'asterisk'
        )
    {
        $queue = 'from-' . strtolower($appName) . '-queue';
        $this->exchanger = $exchanger;
        $this->logger = initLogger(getShortClassName($this));
        $this->logger->info("Connecting to RabbitMQ server");
        $this->connection = new AMQPStreamConnection($host, $port, $user, $password, $vhost);
        $this->channel = $this->connection->channel();
        $this->logger->info("Declaring Queue: {$queue}");
        $this->channel->queue_declare($queue, false, true, false, false);
        $this->logger->info("Declaring Exchanger: {$exchanger}");
        $this->channel->exchange_declare($exchanger, 'direct', false, true, false);
        $this->logger->info("Binding Queue: {$queue}");
        $this->channel->queue_bind($queue, $exchanger);
    }

    /**
     * Publish message to RabbitMQ
     *
     * @param string $body should be a json in a string format
     **/
    function publish(string $body)
    {
        $this->logger->debug("Preparing to send data: {$body}");
        $message = new AMQPMessage(
            $body,
            array('content_type' => 'application/json', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT)
        );
        $this->channel->basic_publish($message, $this->exchanger);
        $this->logger->debug("Message successfully published to RabbitMQ: {$message}");
    }

    /**
     * Stops the AriAMQPPublisher
     */
    function stop()
    {
        $this->channel->close();
        $this->connection->close();
        $this->logger->info('Channel and connection have been closed.');
    }
}