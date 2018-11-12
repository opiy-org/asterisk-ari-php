<?php
/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH
 */
namespace AriStasisApp\ariclients;

use function AriStasisApp\getShortClassName;
use function AriStasisApp\initLogger;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\Client\WebSocket;
use Monolog\Logger;

/**
 * Class AriWebSocketClient
 *
 * @package AriStasisApp\ariclients
 * TODO: Possibility to add many apps with comma seperated names! Don't change BasicStasisApp but
 * create new classes for this use case (many apps, all apps).
 * Also create a new Class for RabbitMQ pass through events (one, many or all applications)
 */
class AriWebSocketClient
{
    /**
     * @var \React\EventLoop\ExtEventLoop
     */
    private $eventLoop;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var mixed
     */
    private $settings;

    /**
     * @var WebSocket
     */
    private $webSocket;

    /**
     * AriWebSocketClient constructor.
     *
     * @param string $stasisAppName If empty, the AriWebSocket will receive ALL events from Asterisk
     * rather then not app specific ones.
     *
     * @param bool $wssEnabled
     * @param string $host
     * @param int $port
     * @param string $rootUrl
     * @param string $user
     * @param string $password
     */
    function __construct(string $stasisAppName = '',
                         bool $wssEnabled = false,
                         string $host = '127.0.0.1',
                         int $port = 8088,
                         string $rootUrl = '/ari',
                         string $user = 'asterisk',
                         string $password = 'asterisk')
    {
        $this->settings = [
            'stasisAppName' => $stasisAppName,
            'wssEnabled' => $wssEnabled,
            'host' => $host,
            'port' => $port,
            'rootUrl' => $rootUrl,
            'user' => $user,
            'password' => $password];
        $this->logger = initLogger(getShortClassName($this));
    }

    /**
     * @param string $eventName
     * @param callable $function
     */
    function handle(string $eventName, callable $function)
    {
        $this->webSocket->on($eventName, $function);
    }

    /**
     *
     */
    function stop()
    {
        $this->webSocket->removeAllListeners();
        $this->eventLoop->stop();
        $webSocketClassName = get_class($this);
        $this->logger->info("[{$webSocketClassName}] has successfully stopped.");
    }

    /**
     * Subscribe to the asterisk instance and start the event loop
     */
    function runWithEventHandlers()
    {
        $ariSettings = $this->settings;
        $wsType = $ariSettings['wssEnabled'] ? 'wss' : 'ws';
        $wsUrl = "{$wsType}://{$ariSettings['host']}:{$ariSettings['port']}{$ariSettings['rootUrl']}";

        // If the name is an empty string, this WebSocket client will listen for ALL events on the asterisk instance.
        $wsQuerySpecificApp =
            "/events?api_key={$ariSettings['user']}:{$ariSettings['password']}&app={$ariSettings['stasisAppName']}";
        $wsQuery = empty($ariSettings['stasisAppName']) ?
            $wsQuerySpecificApp . "&subscribeAll=true" : $wsQuerySpecificApp ;
        $uri = $wsUrl . $wsQuery;

        // Create React EventLoop to listen for incoming messages.
        $this->eventLoop = $eventLoop = \React\EventLoop\Factory::create();
        $reactConnector = new \React\Socket\Connector($eventLoop);
        $ratchetConnector = new \Ratchet\Client\Connector($eventLoop, $reactConnector);

        // Start connecting to the WebSocket and handle incoming events.
        $this->logger->debug("Everything is set up. Trying to connect to Asterisk with URI: '{$uri}'");
        $ratchetConnector($uri)->then(function(WebSocket $webSocket)
            {
                $this->logger->debug('Connection to asterisk successfully set up');
                $this->webSocket = $webSocket;

                // Recieving messages from the WebSocket connection.
                $webSocket
                    ->on('message', function(MessageInterface $message) use ($webSocket) {
                     $this->logger->debug("Received raw message: {$message}");
                    // TODO: isn't this already incoming json? -> The asterisk documentation says so!!!
                     $event = json_decode($message->getPayload());
                    $this->logger->debug("Converted JSON event: {$event}");
                    $webSocket->emit($event->type, [$event]);
                });

                // Closing the WebSocket connection
                $webSocket->on('close', function($code = null, $reason = null) {
                    $this->logger->debug(
                        "Connection was closed ({$code} - {$reason})");
                });

            }, function(\Exception $e) use ($eventLoop) {
                $this->logger->error(
                    "Could not connect to Asterisk: {$e->getMessage()}");
                $eventLoop->stop();
                exit(1);
            });

        // This loop keeps the connection up.
        $eventLoop->run();
        $this->logger->debug('EventLoop is up and running');
    }
}