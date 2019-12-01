<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\WebSocketClient\Woketo;

use JsonMapper;
use Monolog\Logger;
use Nekland\Woketo\Message\MessageHandlerInterface;
use NgVoice\AriClient\RestClient\ResourceClient\Applications;

/**
 * A wrapper for optional nekland/woketo web socket settings.
 *
 * @package NgVoice\AriClient\WebSocketClient\Woketo
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class OptionalSettings
{
    /**
     * @var bool
     */
    private $subscribeAll = false;

    /**
     * @var Applications|null
     */
    private $ariApplicationsClient;

    /**
     * @var Logger|null
     */
    private $logger;

    /**
     * @var JsonMapper|null
     */
    private $jsonMapper;

    /**
     * @var ModifiedWoketoWebSocketClient|null
     */
    private $modifiedWoketoWebSocketClient;

    /**
     * @var MessageHandlerInterface|null
     */
    private $messageHandlerInterface;

    /**
     * @return ModifiedWoketoWebSocketClient|null
     */
    public function getModifiedWoketoWebSocketClient(): ?ModifiedWoketoWebSocketClient
    {
        return $this->modifiedWoketoWebSocketClient;
    }

    /**
     * @param ModifiedWoketoWebSocketClient|null $modifiedWoketoWebSocketClient Optional
     * WebSocketClient to make this class testable
     */
    public function setModifiedWoketoWebSocketClient(
        ?ModifiedWoketoWebSocketClient $modifiedWoketoWebSocketClient
    ): void {
        $this->modifiedWoketoWebSocketClient = $modifiedWoketoWebSocketClient;
    }

    /**
     * @return MessageHandlerInterface|null
     */
    public function getMessageHandlerInterface(): ?MessageHandlerInterface
    {
        return $this->messageHandlerInterface;
    }

    /**
     * @param MessageHandlerInterface|null $messageHandlerInterface Handles incoming
     * Message from Asterisk. Look at AriMessageHandler and RemoteAppMessageHandler
     * for examples.
     */
    public function setMessageHandlerInterface(
        ?MessageHandlerInterface $messageHandlerInterface
    ): void {
        $this->messageHandlerInterface = $messageHandlerInterface;
    }

    /**
     * @return bool
     */
    public function isSubscribeAll(): bool
    {
        return $this->subscribeAll;
    }

    /**
     * @param bool $subscribeAll Subscribe to all Asterisk events.
     * If provided, the applications listed will be subscribed to all events,
     * effectively disabling the application specific subscriptions. Default is 'false'.
     */
    public function setSubscribeAll(bool $subscribeAll): void
    {
        $this->subscribeAll = $subscribeAll;
    }

    /**
     * @return Applications|null
     */
    public function getAriApplicationsClient(): ?Applications
    {
        return $this->ariApplicationsClient;
    }

    /**
     * @param Applications|null $ariApplicationsClient ARI Applications REST client
     * for event filtering on web socket connection.
     */
    public function setAriApplicationsClient(?Applications $ariApplicationsClient): void
    {
        $this->ariApplicationsClient = $ariApplicationsClient;
    }

    /**
     * @return Logger|null
     */
    public function getLogger(): ?Logger
    {
        return $this->logger;
    }

    /**
     * @param Logger|null $logger The logger for this client
     */
    public function setLogger(?Logger $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * @return JsonMapper|null
     */
    public function getJsonMapper(): ?JsonMapper
    {
        return $this->jsonMapper;
    }

    /**
     * @param JsonMapper|null $jsonMapper Mapper for Jsons on objects
     */
    public function setJsonMapper(?JsonMapper $jsonMapper): void
    {
        $this->jsonMapper = $jsonMapper;
    }
}
