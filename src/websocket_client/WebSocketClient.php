<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\websocket_client;

use AriStasisApp\BasicStasisApp;
use Exception;
use http\Exception\RuntimeException;
use Monolog\Logger;
use Nekland\Woketo\Client\WebSocketClient as WoketoWebSocketClient;
use Nekland\Woketo\Message\MessageHandlerInterface;
use function AriStasisApp\{getShortClassName, glueArrayOfStrings, initLogger, parseWebSocketSettings};

/**
 * Class WebSocketClient
 *
 * Within this library you should only either subscribe to one or all running StasisApps on Asterisk.
 * It is a good idea - regarding to the concept of 'separation of concerns' - to have a worker process
 * for each of your applications, so your code doesn't get messy.
 *
 * @package AriStasisApp\ariclients
 *
 */
class WebSocketClient
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var WoketoWebSocketClient
     */
    private $woketoWebSocketClient;

    /**
     * @var MessageHandlerInterface
     */
    private $messageHandler;

    /**
     * WebSocketClient constructor.
     *
     * @param String[] $app Applications to subscribe to. Allows more than one value.
     * @param MessageHandlerInterface $messageHandler Handles incoming messages from Asterisk.
     * Look at LocalAppMessageHandler and RemoteAppMessageHandler for examples.
     * @param array $webSocketSettings The settings for the asterisk web socket.
     * @param bool $subscribeAll Subscribe to all Asterisk events.
     * If provided, the applications listed will be subscribed to all events,
     * effectively disabling the application specific subscriptions. Default is 'false'.
     * @param WoketoWebSocketClient|null $woketoWebSocketClient Optional webSocketClient to make this class testable
     * @throws \RuntimeException
     * TODO: We can see in the logs of asterisk that the application is activated twice. This should not happen
     */
    function __construct(
        array $app,
        MessageHandlerInterface $messageHandler,
        array $webSocketSettings = [],
        $subscribeAll = false,
        WoketoWebSocketClient $woketoWebSocketClient = null
    )
    {
        $this->logger = initLogger(getShortClassName($this));
        $this->messageHandler = $messageHandler;

        /*
         * Within this library you should only either subscribe to one or all running StasisApps on Asterisk.
         * It is a good idea - regarding separation of concerns - to have a worker process for each application
         * you are running, so your code doesn't get messy.
         */

        if ($app === []) {
            throw new RuntimeException('You have to provide at least one app name.');
        }

        foreach ($app as $name) {
            if ($name === '') {
                throw new RuntimeException('App names cannot be empty.');
            }
        }

        // Initialize the WebSocket
        [
            'wssEnabled' => $wssEnabled,
            'host' => $host,
            'port' => $port,
            'rootUri' => $rootUri,
            'user' => $user,
            'password' => $password
        ] = parseWebSocketSettings($webSocketSettings);

        $wsType = $wssEnabled ? 'wss' : 'ws';
        $wsUrl = "{$wsType}://{$host}:{$port}{$rootUri}";
        $app = glueArrayOfStrings($app);
        $subscribeAllParameter = ($subscribeAll) ? '&subscribeAll=true' : '&subscribeAll=false';
        $uri = "{$wsUrl}/events?api_key={$user}:{$password}&app={$app}{$subscribeAllParameter}";
        $this->logger->debug("URI to asterisk: '{$uri}'");
        if (is_null($woketoWebSocketClient)) {
            $this->woketoWebSocketClient = new WoketoWebSocketClient($uri);
        } else {
            $this->woketoWebSocketClient = $woketoWebSocketClient;
        }
    }

    /**
     * Subscribe to the WebSocket of your Asterisk instance and handle Events in a message handler.
     * Look at LocalAppMessageHandler and RemoteAppMessageHandler for example.
     *
     * @param BasicStasisApp $myApp
     */
    function start(): void
    {
        try {
            $this->woketoWebSocketClient->start($this->messageHandler);
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            exit(1);
        }
    }
}