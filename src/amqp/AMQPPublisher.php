<?php

/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\amqp;

use function AriStasisApp\{initLogger, getShortClassName, parseAMQPSettings};
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class AMQPPublisher
 *
 * @package AriStasisApp\amqp
 */
class AMQPPublisher
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
    private $exchange;

    /**
     * @var array
     */
    private $messageOptions;

    /**
     * @var string
     */
    private $lowerAppName;

    /**
     * AMQPPublisher constructor.
     *
     * The default values are for RabbitMQ but you can choose whatever implements the AMQP protocol!
     *
     * @param string $appName
     * @param array $amqpSettings
     */
    function __construct(string $appName = '', array $amqpSettings = [])
    {
        ['host' => $host, 'port' => $port, 'user' => $user,
            'password' => $password, 'vhost' => $vhost, 'exchange' => $exchange] = parseAMQPSettings($amqpSettings);
        $nr = 0;
        $this->logger = initLogger(getShortClassName($this). '-' . $appName);
        $lowerAppName = strtolower($appName);
        $this->exchange = $exchange;

        if ($lowerAppName === '')
        {
            $lowerAppName = 'all-stasis-apps';
        }
        $this->lowerAppName = $lowerAppName;
        $queue = $lowerAppName;

        $this->messageOptions =
            ['content_type' => 'application/json', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT];
        $nr = $nr + 1;
        $this->logger->info("Connecting to AMQP server {$nr}");
        $this->connection = new AMQPStreamConnection($host, $port, $user, $password, $vhost);
        $this->channel = $this->connection->channel();
        $this->logger->info("Declaring Exchanger: '{$exchange}'");
        $this->channel->exchange_declare($exchange, 'direct', false, true, false);
        $this->logger->info("Declaring Queue: '{$queue}'");
        $this->channel->queue_declare($queue, false, true, false, false);
        $this->logger->info("Binding Queue: '{$queue}'");
        $this->channel->queue_bind($queue, $exchange, $lowerAppName);
    }

    /**
     * Publish message to AMQP
     *
     * @param string $body should be a json in a string format
     */
    function publish(string $body)
    {
        $this->logger->debug("Preparing to send data: {$body}");
        $this->channel->basic_publish(new AMQPMessage($body, $this->messageOptions),
            $this->exchange, $this->lowerAppName);
        $this->logger->debug('Message successfully published to AMQP exchange');
    }

    /**
     * Stops the AMQPPublisher
     */
    function stop()
    {
        $this->channel->close();
        $this->connection->close();
        $this->logger->info('Channel and connection have been closed');
    }
}