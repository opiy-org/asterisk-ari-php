<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Client\WebSocket\Woketo;

use Nekland\Woketo\Message\MessageHandlerInterface;

/**
 * A wrapper for optional nekland/woketo web socket settings.
 *
 * @package NgVoice\AriClient\Client\WebSocket\Woketo
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Settings
{
    private ?ModifiedWoketoWebSocketClient $modifiedWoketoWebSocketClient = null;

    /**
     * Handles incoming Events from Asterisk.
     * Look at AriMessageHandler and RemoteAppMessageHandler for examples.
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
}
