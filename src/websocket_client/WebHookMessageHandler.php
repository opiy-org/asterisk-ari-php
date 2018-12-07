<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\websocket_client;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Monolog\Logger;
use Nekland\Woketo\Core\AbstractConnection;
use Nekland\Woketo\Exception\WebsocketException;
use Nekland\Woketo\Message\TextMessageHandler;
use function AriStasisApp\{getShortClassName, initLogger, parseMyApiSettings};

/**
 * Class WebHookMessageHandler
 *
 * @package AriStasisApp\rabbitmq
 */
class WebHookMessageHandler extends TextMessageHandler
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var GuzzleClient
     */
    private $guzzleClient;

    /**
     * @var string
     */
    private $webHookUri;

    /**
     * WebHookMessageHandler constructor.
     * @param array $myApiSettings
     */
    function __construct(array $myApiSettings)
    {
        $this->logger = initLogger(getShortClassName($this));
        $myApiSettings = parseMyApiSettings($myApiSettings);

        if ($myApiSettings['httpsEnabled'] === true) {
            $httpType = 'https';
        } else {
            $httpType = 'http';
        }

        $baseUri = "{$httpType}://{$myApiSettings['host']}:{$myApiSettings['port']}";
        $this->webHookUri = $myApiSettings['webHookUri'];

        $guzzleClientSettings = ['base_uri' => $baseUri];

        /*
         * TODO: Add authentication methods (user+pass or/and APIkey)
         * if (isset($myApiSettings['user']) && isset($myApiSettings['password'])) {
         *      $guzzleClientSettings = $guzzleClientSettings + ['auth' =>....];
         * }
         */
        $this->guzzleClient = new GuzzleClient($guzzleClientSettings);
    }


    /**
     * @param AbstractConnection $connection
     */
    public function onConnection(AbstractConnection $connection)
    {
        $this->logger->debug('Connection to asterisk successfully. Waiting for messages...');
    }


    /**
     * @param string $data
     * @param AbstractConnection $connection
     */
    public function onMessage(string $data, AbstractConnection $connection)
    {
        $this->logger->debug("Received raw message from asterisk WebSocket server: {$data}");

        try {
            $this->guzzleClient->request('PUT', $this->webHookUri, ['json' => json_decode($data)]);
        } catch (GuzzleException $exception) {
            $this->logger->error($exception->getMessage());
        }

        $this->logger->debug("Message successfully sent to {$this->webHookUri} on local application");
    }


    /**
     * @param AbstractConnection $connection
     */
    public function onDisconnect(AbstractConnection $connection)
    {
        $this->logger->info('Connection to Asterisk was closed.');
    }


    /**
     * @param WebsocketException $websocketException
     * @param AbstractConnection $connection
     * @throws WebsocketException
     */
    public function onError(WebsocketException $websocketException, AbstractConnection $connection)
    {
        $this->logger->error($websocketException->getMessage());
        throw $websocketException;
    }
}