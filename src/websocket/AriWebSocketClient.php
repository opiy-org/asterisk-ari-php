<?php

/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\rest_clients;

use function AriStasisApp\{getShortClassName, initLogger};
use AriStasisApp\amqp\AriWebSocketMessageHandler;
use Nekland\Woketo\Client\WebSocketClient;
use Monolog\Logger;

/**
 * Class AriWebSocketClient
 *
 * @package AriStasisApp\ariclients
 * TODO: Possibility to add many apps with comma seperated names! Don't change BasicStasisApp but
 * create new classes for this use case (many apps, all apps).
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
     * @param string $stasisAppName If empty, the AriWebSocketClient will receive ALL Asterisk events.
     * @param bool $wssEnabled
     * @param string $host
     * @param int $port
     * @param string $rootUrl
     * @param string $user
     * @param string $password
     * TODO: Make sure only one stasisAppName is handed over. Comma separated list is not allowed.
     * Only one Socket for all events or one socket per StasisApp
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
     * Subscribe to the asterisk instance and start the event loop
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
        $uri = $wsUrl . $wsQuery;

        try
        {
            $this->webSocketClient = new WebSocketClient($uri);
            $this->webSocketClient->start(new AriWebSocketMessageHandler($this->settings['stasisAppName']));
        }
        catch (\Exception $e)
        {
            $this->logger->error("Could not connect to Asterisk: {$e->getMessage()}");
            exit(1);
        }
    }
}