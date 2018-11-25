<?php

/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\websocket_client;

use function AriStasisApp\{getShortClassName, initLogger, parseWebSocketSettings};
use AriStasisApp\amqp\AMQPPublisher;
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
     * @var MessageHandler
     */
    private $messageHandler;

    /**
     * WebSocketClient constructor.
     *
     * @param string $appName
     * @param array $webSocketSettings
     * @param array $amqpSettings
     *
     * TODO: There is still a bug, because we can see in the logs of asterisk that the application is activated twice
     *
     */
    function __construct(string $appName = '', array $webSocketSettings = [], array $amqpSettings = [])
    {
        $this->logger = initLogger(getShortClassName($this) . "-{$appName}");
        $amqpPublisher = new AMQPPublisher($appName, $amqpSettings);
        $this->messageHandler = new MessageHandler($amqpPublisher);

        // Initialize the WebSocket
        $webSocketSettings = parseWebSocketSettings($webSocketSettings);
        ['wssEnabled' => $wssEnabled, 'host' => $host, 'port' => $port,
            'rootUri' => $rootUri, 'user' => $user, 'password' => $password] = $webSocketSettings;
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
     */
    function run()
    {
        try {
            $this->webSocketClient->start($this->messageHandler);
        }
        catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            exit(1);
        }
    }
}