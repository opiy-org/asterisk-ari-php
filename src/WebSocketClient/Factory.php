<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\WebSocketClient;

use NgVoice\AriClient\StasisApplicationInterface;
use NgVoice\AriClient\WebSocketClient\Ratchet\{
    OptionalSettings as OptionalRatchetSettings,
    WebSocketClient as RatchetWebSocketClient};
use NgVoice\AriClient\WebSocketClient\Woketo\{OptionalSettings as OptionalWoketoSettings,
    WebSocketClient as WoketoWebSocketClient};

/**
 * Factory class to create new instances of an ARI web socket client
 * depending on the implementation preferred.
 *
 * @package NgVoice\AriClient\WebSocketClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Factory
{
    /**
     * Create a new web socket client.
     *
     * @param Settings $ariWebSocketClientSettings The
     * web socket client settings
     * @param StasisApplicationInterface $myStasisApp Your Stasis app
     * that shall register within the connected Asterisk instance
     *
     * @return WebSocketClientInterface The currently recommended
     * web socket client implementation.
     */
    public static function create(
        Settings $ariWebSocketClientSettings,
        StasisApplicationInterface $myStasisApp
    ): WebSocketClientInterface {
        return self::createWoketo($ariWebSocketClientSettings, $myStasisApp);
    }

    /**
     * Create an instance of the Ratchet web socket client implementation.
     *
     * @param Settings $ariWebSocketClientSettings The
     * web socket client settings
     * @param StasisApplicationInterface $myStasisApp Your Stasis app
     * that shall register within the connected Asterisk instance
     * @param OptionalRatchetSettings|null $optionalRatchetSettings Optional
     * settings for the specific Ratchet implementation of the web socket
     * client
     *
     * @return RatchetWebSocketClient The ratchet web socket client
     * implementation.
     */
    public static function createRatchet(
        Settings $ariWebSocketClientSettings,
        StasisApplicationInterface $myStasisApp,
        OptionalRatchetSettings $optionalRatchetSettings = null
    ): RatchetWebSocketClient {
        return new RatchetWebSocketClient(
            $ariWebSocketClientSettings,
            $myStasisApp,
            $optionalRatchetSettings
        );
    }

    /**
     * Create an instance of the Woketo web socket client implementation.
     *
     * @param Settings $ariWebSocketClientSettings The
     * web socket client settings
     * @param StasisApplicationInterface $myStasisApp Your Stasis app
     * that shall register within the connected Asterisk instance
     * @param OptionalWoketoSettings|null $optionalWoketoSettings Optional
     * settings for the specific Woketo implementation of the web socket
     * client
     *
     * @return WoketoWebSocketClient The woketo web socket client
     * implementation.
     */
    public static function createWoketo(
        Settings $ariWebSocketClientSettings,
        StasisApplicationInterface $myStasisApp,
        OptionalWoketoSettings $optionalWoketoSettings = null
    ): WoketoWebSocketClient {
        return new WoketoWebSocketClient(
            $ariWebSocketClientSettings,
            $myStasisApp,
            $optionalWoketoSettings
        );
    }
}
