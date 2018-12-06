<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\websocket_client;

use AriStasisApp\BasicStasisApp;
use Monolog\Logger;
use Nekland\Woketo\Client\WebSocketClient as WoketoWebSocketClient;
use function AriStasisApp\{getShortClassName, initLogger, parseWebSocketSettings};

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
     * @param array $webSocketSettings
     * @param string $subscribingAppName Leave this empty if you want to listen for all events in asterisk
     * (not app specific events).
     *
     * TODO: We can see in the logs of asterisk that the application is activated twice. This should not happen
     */
    function __construct(array $webSocketSettings = [], string $subscribingAppName = '')
    {
        $this->logger = initLogger(getShortClassName($this));

        /*
         * Within this library you should only either subscribe to one or all running StasisApps on Asterisk.
         * It is a good idea - regarding separation of concerns - to have a worker process for each application
         * you are running, so your code doesn't get messy.
         */


        // Initialize the WebSocket
        $webSocketSettings = parseWebSocketSettings($webSocketSettings);

        [
            'wssEnabled' => $wssEnabled,
            'host' => $host,
            'port' => $port,
            'rootUri' => $rootUri,
            'user' => $user,
            'password' => $password
        ] = $webSocketSettings;

        $wsType = $wssEnabled ? 'wss' : 'ws';
        $wsUrl = "{$wsType}://{$host}:{$port}{$rootUri}";
        $wsQuerySpecificApp = "/events?api_key={$user}:{$password}&app={$subscribingAppName}";
        $wsQuery = ($subscribingAppName === '') ? "{$wsQuerySpecificApp}&subscribeAll=true" : $wsQuerySpecificApp;
        $uri = "{$wsUrl}{$wsQuery}";
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
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            exit(1);
        }
    }

    /**
     * Subscribe to the WebSocket of your Asterisk instance and pass the events to another API of yours.
     *
     * @param array $myApiSettings
     */
    function runWithWebHook(array $myApiSettings) {
        try {
            $this->woketoWebSocketClient->start(new WebHookMessageHandler($myApiSettings));
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            exit(1);
        }
    }
}