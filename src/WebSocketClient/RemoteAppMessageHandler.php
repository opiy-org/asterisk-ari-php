<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\WebSocketClient;

use GuzzleHttp\Client;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Monolog\Logger;
use Nekland\Woketo\Core\AbstractConnection;
use Nekland\Woketo\Exception\WebsocketException;
use Nekland\Woketo\Message\TextMessageHandler;
use function NgVoice\AriClient\{getShortClassName, initLogger, parseMyApiSettings};

/**
 * Class RemoteAppMessageHandler
 * @package NgVoice\AriClient\WebSocketClient
 */
class RemoteAppMessageHandler extends TextMessageHandler
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
    private $rootUri;

    /**
     * RemoteAppMessageHandler constructor.
     * @param array $remoteApiSettings
     * @param Client $guzzleClient
     */
    public function __construct(array $remoteApiSettings, Client $guzzleClient = null)
    {
        $this->logger = initLogger(getShortClassName($this));
        $remoteApiSettings = parseMyApiSettings($remoteApiSettings);

        if ($remoteApiSettings['httpsEnabled'] === true) {
            $httpType = 'https';
        } else {
            $httpType = 'http';
        }

        $baseUri = "{$httpType}://{$remoteApiSettings['host']}:{$remoteApiSettings['port']}";
        $this->rootUri = $remoteApiSettings['rootUri'];
        if ($guzzleClient === null) {
            $this->guzzleClient = new GuzzleClient(
                ['base_uri' => $baseUri, 'auth' => [$remoteApiSettings['user'], $remoteApiSettings['password']]]
            );
        } else {
            $this->guzzleClient = $guzzleClient;
        }
    }

    /**
     * @inheritdoc
     */
    public function onConnection(AbstractConnection $connection): void
    {
        $this->logger->debug('Connection to asterisk successfully. Waiting for Message...');
    }

    /**
     * @inheritdoc
     */
    public function onMessage(string $data, AbstractConnection $connection): void
    {
        try {
            $this->logger->debug("Received raw message from asterisk WebSocket server: {$data}");
            // TODO: Will I have to decode $data first? This would take a lot of resources...
            $decodedJson = json_decode($data);
            $ariEventType = lcfirst($decodedJson->type);
            $ariAppName = lcfirst($decodedJson->application);
            $this->guzzleClient->request('PUT', $this->rootUri . "/{$ariAppName}/{$ariEventType}",
                ['headers' => ['Content-Type' => 'application/json'], 'body' => $data]
            );
            $this->logger->debug("Message successfully sent to {$this->rootUri} on local application");
        } catch (GuzzleException $exception) {
            $this->logger->error($exception->getMessage());
        }
    }

    /**
     * @inheritdoc
     */
    public function onDisconnect(AbstractConnection $connection): void
    {
        $this->logger->info('Connection to Asterisk was closed.');
    }

    /**
     * @inheritdoc
     * @throws WebsocketException
     */
    public function onError(WebsocketException $websocketException, AbstractConnection $connection): void
    {
        $this->logger->error($websocketException->getMessage());
        throw $websocketException;
    }
}