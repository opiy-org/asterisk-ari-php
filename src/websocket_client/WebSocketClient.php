<?php

/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\websocket_client;

use Monolog\Logger;
use Nekland\Woketo\Client\WebSocketClient as WoketoWebSocketClient;
use function AriStasisApp\{getShortClassName, initLogger, parseWebSocketSettings};

/**
 * Class WebSocketClient
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
     * @var MessageHandler
     */
    private $messageHandler;

    /**
     * WebSocketClient constructor.
     *
     * @param string $appName
     * @param array $webSocketSettings
     * @param array $myApiSettings
     *
     * TODO: We can see in the logs of asterisk that the application is activated twice. This should not happen
     */
    function __construct(string $appName = '', array $webSocketSettings = [], array $myApiSettings = [])
    {
        $shortClassName = getShortClassName($this);
        if ($appName === '') {
            $loggerName = $shortClassName . '-AllStasisApps';
        } else {
            $loggerName = $shortClassName . "-{$appName}";
        }
        $this->logger = initLogger($loggerName);
        $this->messageHandler = new MessageHandler($myApiSettings);

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

        $wsQuerySpecificApp = "/events?api_key={$user}:{$password}&app='{$appName}'";
        $wsQuery = ($appName === '') ? "{$wsQuerySpecificApp}&subscribeAll=true" : $wsQuerySpecificApp;
        $uri = "{$wsUrl}{$wsQuery}";
        $this->logger->debug("URI to asterisk: '{$uri}'");
        $this->woketoWebSocketClient = new WoketoWebSocketClient($uri);
    }

    /**
     * Subscribe to the WebSocket of your Asterisk instance
     */
    function run()
    {
        try {
            $this->woketoWebSocketClient->start($this->messageHandler);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            exit(1);
        }
    }
}