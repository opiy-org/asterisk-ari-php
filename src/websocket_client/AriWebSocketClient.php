<?php

/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\websocket_client;

use function AriStasisApp\{getShortClassName, initLogger};
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
     * @var mixed
     */
    private $settings;

    /**
     * @var WebSocketClient
     */
    private $webSocketClient;

    /**
     * AriWebSocketClient constructor.
     *
     * @param string $stasisAppName
     * @param bool $wssEnabled
     * @param string $host
     * @param int $port
     * @param string $rootUrl
     * @param string $user
     * @param string $password
     */
    function __construct(string $stasisAppName = '', bool $wssEnabled = false, string $host = '127.0.0.1',
                         int $port = 8088, string $rootUrl = '/ari', string $user = 'asterisk',
                         string $password = 'asterisk')
    {
        $this->settings = ['stasisAppName' => $stasisAppName, 'wssEnabled' => $wssEnabled, 'host' => $host,
            'port' => $port, 'rootUrl' => $rootUrl, 'user' => $user, 'password' => $password];
        $this->logger = initLogger(getShortClassName($this));
    }

    /**
     * Subscribe to the WebSocket of your Asterisk instance
     *
     * @throws \Exception
     */
    function publishWithAMQP()
    {
        $ariSettings = $this->settings;
        $wsType = $ariSettings['wssEnabled'] ? 'wss' : 'ws';
        $wsUrl = "{$wsType}://{$ariSettings['host']}:{$ariSettings['port']}{$ariSettings['rootUrl']}";

        $wsQuerySpecificApp =
            "/events?api_key={$ariSettings['user']}:{$ariSettings['password']}&app={$ariSettings['stasisAppName']}";
        $wsQuery = empty($ariSettings['stasisAppName']) ?
            $wsQuerySpecificApp . "&subscribeAll=true" : $wsQuerySpecificApp;
        $uri = "{$wsUrl}{$wsQuery}";
        $this->webSocketClient = new WebSocketClient($uri);
        $this->webSocketClient->start(new AriPassThroughMessageHandler($this->settings['stasisAppName']));

    }
}