<?php

/**
 * Using the wrapping library to consume events from RabbitMQ
 */
namespace AriStasisApp\amqp;

use function AriStasisApp\{
    initLogger,
    getShortClassName,
    parseAMQPSettings,
    parseAriSettings};
use AriStasisApp\http_client\{
    BridgesRestClient,
    ChannelsRestClient,
    AsteriskRestClient,
    ApplicationsRestClient,
    DeviceStatesRestClient,
    EndpointsRestClient,
    EventsRestClient,
    MailboxesRestClient,
    PlaybacksRestClient,
    RecordingsRestClient,
    SoundsRestClient};
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class AriAMQPConsumer
 *
 * @package AriStasisApp\amqp
 */
class AriAMQPConsumer
{
    private $logger;
    private $sounds;
    private $events;
    private $bridges;
    private $channels;
    private $asterisk;
    private $endpoints;
    private $mailboxes;
    private $playbacks;
    private $recordings;
    private $ariSettings;
    private $amqpSettings;
    private $applications;
    private $deviceStates;

    function __construct(array $ariSettings = [], array $amqpSettings = [])
    {
        $this->logger = initLogger(getShortClassName($this));
        $this->ariSettings = parseAriSettings($ariSettings);
        $this->amqpSettings = parseAMQPSettings($amqpSettings);
        $this->logger->debug('AriSettings and AMQPSettings parsed.');


        $host = $this->ariSettings['host'];
        $port = $this->ariSettings['port'];
        $user = $this->ariSettings['user'];
        $rootUrl = $this->ariSettings['rootUrl'];
        $password = $this->ariSettings['password'];
        $httpsEnabled = $this->ariSettings['httpsEnabled'];

        // Initialize the ARI http clients
        $this->events = new EventsRestClient($httpsEnabled, $host, $port, $rootUrl, $user, $password);
        $this->sounds = new SoundsRestClient($httpsEnabled, $host, $port, $rootUrl, $user, $password);
        $this->bridges = new BridgesRestClient($httpsEnabled, $host, $port, $rootUrl, $user, $password);
        $this->channels = new ChannelsRestClient($httpsEnabled, $host, $port, $rootUrl, $user, $password);
        $this->asterisk = new AsteriskRestClient($httpsEnabled, $host, $port, $rootUrl, $user, $password);
        $this->mailboxes = new MailboxesRestClient($httpsEnabled, $host, $port, $rootUrl, $user, $password);
        $this->playbacks = new PlaybacksRestClient($httpsEnabled, $host, $port, $rootUrl, $user, $password);
        $this->endpoints = new EndpointsRestClient($httpsEnabled, $host, $port, $rootUrl, $user, $password);
        $this->recordings = new RecordingsRestClient($httpsEnabled, $host, $port, $rootUrl, $user, $password);
        $this->applications = new ApplicationsRestClient($httpsEnabled, $host, $port, $rootUrl, $user, $password);
        $this->deviceStates = new DeviceStatesRestClient($httpsEnabled, $host, $port, $rootUrl, $user, $password);

        $this->logger->info('All http clients have been initialized successfully');

        // Get ready to consume from an ampq queue
        $amqpSettings = parseAMQPSettings($amqpSettings);
        $lowerAppName = strtolower($amqpSettings['appName']);
        $exchange = $amqpSettings['exchange'];

        if (empty($lowerAppName))
        {
            $lowerAppName = 'all-stasis-apps';
        }
        $queue = 'to-' . $lowerAppName . '-queue';
        $consumerTag = 'consumer';

        $this->logger->info("Connecting to AMQP server");
        // TODO: Possibility to add multiple hosts?! Think about the architecture here
        $connection = new AMQPStreamConnection(
            $amqpSettings['host'], $amqpSettings['port'], $amqpSettings['user'],
            $amqpSettings['password'], $amqpSettings['vhost']
        );
        $channel = $connection->channel();
        $this->logger->info("Declaring Queue: {$queue}");
        $channel->queue_declare($queue, false, true, false, false);
        $this->logger->info("Declaring Exchanger: {$exchange}");
        $channel->exchange_declare($exchange, 'direct', false, true, false);
        $this->logger->info("Binding Queue: {$queue}");
        $channel->queue_bind($queue, $exchange);
        register_shutdown_function([$this, 'shutdown'], $channel, $connection, $amqpSettings['appName']);

        // Start consuming messages
        $channel->basic_consume($queue, $consumerTag, false, false, false, false, [$this,'handleMessage']);

        // Loop as long as the channel has callbacks registered
        while (count($channel->callbacks)) {
            try {
                $channel->wait();
            }
            catch (\ErrorException $errorException){
                $this->logger->error($errorException);
            }
        }
        $this->logger->debug('Consumer object was left by its own.');
    }

    /**
     * @param AMQPMessage $message
     */
    function handleMessage($message)
    {
        // TODO: Look, if the element from the queue is for this or for any asterisk instance. Thats ok.
        // If not, send a nack

        // TODO: Is json-decoding necessary here? There is a $message->body method for this.
        $transfered =  print_r($message->body);
        $this->logger->debug("Consumer consumed message: {$transfered}");
        if (true)
        {
            $message->get('channel')->basic_ack($message->delivery_info['delivery_tag']);
            $this->logger->debug("Consumer acknowledged message: {$transfered}");

        }
        else {
            $message->get('channel')->basic_nack($message->delivery_info['delivery_tag']);
            $this->logger->debug("Consumer denied message: {$transfered}");
        }

        // Send a message with the string "quit" to cancel the consumer.
        if ($message->body === 'quit') {
            $message->get('channel')->basic_cancel($message->delivery_info['consumer_tag']);
            $this->logger->debug("Consumer was actively quit by 'quit' command from queue");
        }
    }

    function shutdown(AMQPChannel $channel, AMQPStreamConnection $connection, string $appName)
    {
        $channel->close();
        $connection->close();
        // TODO: Add appName in case it is empty
        print_r("AMQP Consumer '{$appName}' has terminated.\n");
    }
}