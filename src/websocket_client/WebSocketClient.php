<?php

/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\websocket_client;

use function AriStasisApp\{getShortClassName, initLogger, parseAriWebSocketSettings};
use Monolog\Logger;

/**
 * Class WebSocketClient
 *
 * @package AriStasisApp\ariclients
 *
 * TODO: Also create a new Class for RabbitMQ pass through events (one, many or all applications)
 */
class WebSocketClient
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var array
     */
    private $webSocketSettings;

    /**
     * @var WebSocketClient
     */
    private $webSocketClient;

    /**
     * WebSocketClient constructor.
     *
     * @param array $webSocketSettings
     */
    function __construct(array $webSocketSettings = [])
    {
        $this->webSocketSettings = parseAriWebSocketSettings($webSocketSettings);
        $this->logger = initLogger(getShortClassName($this));
    }

    /**
     * Subscribe to the WebSocket of your Asterisk instance
     *
     * @throws \Exception
     */
    function publishWithAMQP()
    {
        ['appName' => $appName, 'wssEnabled' => $wssEnabled,
            'host' => $host, 'port' => $port, 'rootUri' => $rootUri,
            'user' => $user, 'password' => $password
        ] = $this->webSocketSettings;
        $wsType = $wssEnabled ? 'wss' : 'ws';
        $wsUrl = "{$wsType}://{$host}:{$port}{$rootUri}";

        $wsQuerySpecificApp = "/events?api_key={$user}:{$password}&app={$appName}";
        $wsQuery = empty($stasisAppName) ? $wsQuerySpecificApp . "&subscribeAll=true" : $wsQuerySpecificApp;
        $uri = "{$wsUrl}{$wsQuery}";
        $this->webSocketClient = new \Nekland\Woketo\Client\WebSocketClient($uri);
        $this->webSocketClient->start(new MessageHandler($appName));

    }
}