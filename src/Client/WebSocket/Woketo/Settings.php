<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Client\WebSocket\Woketo;

use Nekland\Woketo\Message\MessageHandlerInterface;
use NgVoice\AriClient\Client\Rest\Resource\Applications;

/**
 * A wrapper for optional nekland/woketo web socket settings.
 *
 * @package NgVoice\AriClient\WebSocket\Woketo
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Settings
{
    /**
     * Subscribe to all Asterisk events.
     * If provided, the application will be subscribed to all events,
     * effectively disabling the application specific subscriptions.
     * Default is 'false'.
     */
    private bool $subscribeAll = false;

    /**
     * ARI Applications REST client for event filtering on web socket connection.
     */
    private ?Applications $ariApplicationsClient = null;

    private ?ModifiedWoketoWebSocketClient $modifiedWoketoWebSocketClient = null;

    /**
     * Handles incoming Event from Asterisk.
     * Look at AriMessageHandler and RemoteAppMessageHandler
     * for examples.
     */
    private ?MessageHandlerInterface $messageHandlerInterface = null;

    /**
     * @return ModifiedWoketoWebSocketClient|null
     */
    public function getModifiedWoketoWebSocketClient(): ?ModifiedWoketoWebSocketClient
    {
        return $this->modifiedWoketoWebSocketClient;
    }

    /**
     * @param ModifiedWoketoWebSocketClient|null $modifiedWoketoWebSocketClient Optional
     * WebSocket to make this class testable
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
     * @param MessageHandlerInterface|null $messageHandlerInterface @see property
     * $messageHandlerInterface
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
     * @param bool $subscribeAll @see property $subscribeAll
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
     * @param Applications|null $ariApplicationsClient @see property
     * $ariApplicationsClient
     */
    public function setAriApplicationsClient(?Applications $ariApplicationsClient): void
    {
        $this->ariApplicationsClient = $ariApplicationsClient;
    }
}
