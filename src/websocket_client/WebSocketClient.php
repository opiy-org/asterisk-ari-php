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
     * WebSocketClient constructor.
     *
     * @param String[] $app Applications to subscribe to. Allows more than one value.
     * @param array $webSocketSettings The settings for the asterisk web socket.
     * @param bool $subscribeAll Subscribe to all Asterisk events.
     * If provided, the applications listed will be subscribed to all events,
     * effectively disabling the application specific subscriptions. Default is 'false'.
     * TODO: We can see in the logs of asterisk that the application is activated twice. This should not happen
     */
    function __construct(array $app, array $webSocketSettings = [], $subscribeAll = false)
    {
        $this->logger = initLogger(getShortClassName($this));

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
        $this->woketoWebSocketClient = new WoketoWebSocketClient($uri);
    }

    /**
     * Subscribe to the WebSocket of your Asterisk instance and handle Events in your own app.
     *
     * @param BasicStasisApp $myApp
     */
    function runWithLocalApp(BasicStasisApp $myApp): void
    {
        try {
            $this->woketoWebSocketClient->start(new LocalAppMessageHandler($myApp));
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            exit(1);
        }
    }

    /**
     * Subscribe to the WebSocket of your Asterisk instance and pass the events to another API of yours.
     *
     * @param array $remoteApiSettings
     */
    function runWithRemoteApp(array $remoteApiSettings)
    {
        try {
            $this->woketoWebSocketClient->start(new RemoteAppMessageHandler($remoteApiSettings));
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            exit(1);
        }
    }
}