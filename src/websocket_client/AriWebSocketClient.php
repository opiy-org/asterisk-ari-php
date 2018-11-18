<?php

/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\websocket_client;

use function AriStasisApp\{getShortClassName, initLogger, parseAriWebSocketSettings};
use Nekland\Woketo\Client\WebSocketClient;
use Monolog\Logger;

/**
 * Class AriWebSocketClient
 *
 * @package AriStasisApp\ariclients
 *
 * TODO: Also create a new Class for RabbitMQ pass through events (one, many or all applications)
 */
class AriWebSocketClient
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
     * AriWebSocketClient constructor.
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
        [$appName, $wssEnabled, $host, $port, $rootUri, $user, $password] = $this->webSocketSettings;
        $wsType = $wssEnabled ? 'wss' : 'ws';
        $wsUrl = "{$wsType}://{$host}:{$port}{$rootUri}";

        $wsQuerySpecificApp = "/events?api_key={$user}:{$password}&app={$appName}";
        $wsQuery = empty($stasisAppName) ? $wsQuerySpecificApp . "&subscribeAll=true" : $wsQuerySpecificApp;
        $uri = "{$wsUrl}{$wsQuery}";
        $this->webSocketClient = new WebSocketClient($uri);
        $this->webSocketClient->start(new AriPassThroughMessageHandler($appName));

    }
}