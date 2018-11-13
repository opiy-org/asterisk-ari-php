<?php

/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\amqp;

use function AriStasisApp\{initLogger, getShortClassName};
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once __DIR__ . '/../helping_functions.php';

/**
 * Class AriAMQPPublisher
 *
 * @package AriStasisApp\amqp
 */
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
    private $exchange;

    /**
     * @var array
     */
    private $messageOptions;

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
     * @param string $exchange
     */
    function __construct(
        string $appName = '',
        string $host = 'localhost',
        int $port = 5672,
        string $user = 'guest',
        string $password = 'guest',
        string $vhost = '/',
        string $exchange = 'asterisk'
        )
    {
        $queue = 'from-' . strtolower($appName) . '-queue';
        $this->exchange = $exchange;
        $this->logger = initLogger(getShortClassName($this));
        $this->messageOptions =
            ['content_type' => 'application/json', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT];
        $this->logger->info("Connecting to AMQP server");
        // TODO: Possibility to add multiple hosts?! Think about the architecture here
        $this->connection = new AMQPStreamConnection($host, $port, $user, $password, $vhost);
        $this->channel = $this->connection->channel();
        $this->logger->info("Declaring Queue: {$queue}");
        $this->channel->queue_declare($queue, false, true, false, false);
        $this->logger->info("Declaring Exchanger: {$exchange}");
        $this->channel->exchange_declare($exchange, 'direct', false, true, false);
        $this->logger->info("Binding Queue: {$queue}");
        $this->channel->queue_bind($queue, $exchange);
    }

    /**
     * Publish message to AMQP
     *
     * @param string $body should be a json in a string format
     **/
    function publish(string $body)
    {
        $this->logger->debug("Preparing to send data: {$body}");
        $this->channel->basic_publish(new AMQPMessage($body, $this->messageOptions), $this->exchange);
        $this->logger->debug('Message successfully published to AMQP exchange');
    }

    /**
     * Stops the AriAMQPPublisher
     */
    function stop()
    {
        $this->channel->close();
        $this->connection->close();
        $this->logger->info('Channel and connection have been closed');
    }
}