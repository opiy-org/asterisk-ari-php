<?php

/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\websocket_client;

use AriStasisApp\amqp\AMQPPublisher;
use function AriStasisApp\{getShortClassName, initLogger, parseAMQPSettings, parseWebSocketSettings};
use Monolog\Logger;

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
     * @var WebSocketClient
     */
    private $webSocketClient;

    /**
     * @var array
     */
    private $amqpSettings;

    /**
     * WebSocketClient constructor.
     *
     * @param string $appName
     * @param array $webSocketSettings
     * @param array $amqpSettings
     * TODO: There is still a bug, because we can see in the logs of asterisk that the application is activated twice
     */
    function __construct(string $appName, array $webSocketSettings = [], array $amqpSettings = [])
    {
        $this->logger = initLogger(getShortClassName($this));

        // Initialize the AMQPPublisher
        $amqpSettings = array_merge($amqpSettings, ['appName' => $appName]);
        $this->amqpSettings = parseAMQPSettings($amqpSettings);

        // Initialize the WebSocket
        $webSocketSettings = array_merge($webSocketSettings, ['appName' => $appName]);
        $webSocketSettings = parseWebSocketSettings($webSocketSettings);
        ['appName' => $appName, 'wssEnabled' => $wssEnabled,
            'host' => $host, 'port' => $port, 'rootUri' => $rootUri,
            'user' => $user, 'password' => $password
        ] = $webSocketSettings;
        $wsType = $wssEnabled ? 'wss' : 'ws';
        $wsUrl = "{$wsType}://{$host}:{$port}{$rootUri}";

        $wsQuerySpecificApp = "/events?api_key={$user}:{$password}&app={$appName}";
        $wsQuery = ($appName === '') ? "{$wsQuerySpecificApp}&subscribeAll=true" : $wsQuerySpecificApp;
        $uri = "{$wsUrl}{$wsQuery}";
        $this->logger->debug("URI to asterisk: '{$uri}'");
        $this->webSocketClient = new \Nekland\Woketo\Client\WebSocketClient($uri);
    }

    /**
     * Subscribe to the WebSocket of your Asterisk instance
     *
     * @throws \Exception
     */
    function run()
    {
        $this->webSocketClient->start(new MessageHandler(new AMQPPublisher($this->amqpSettings)));
    }
}