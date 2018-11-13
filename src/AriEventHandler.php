<?php

namespace AriStasisApp;


use AriStasisApp\websocket\AriWebSocketClient;

/**
 * Class AriEventHandler
 *
 * @package AriStasisApp\websocket
 */
class AriEventHandler
{
    /**
     * @param array $stasisAppNames Leave empty, if you want to listen for all events from your WebSocket.
     * @throws \Exception
     */
    static function startWebSocketsAndAMQPPublishers(array $stasisAppNames = [])
    {
        switch ($stasisAppNames){
            case []:
                $ariWebSocketClient = new AriWebSocketClient('');
                $ariWebSocketClient->publishWithAMQP();
                break;

            default:
                foreach ($stasisAppNames as $appName)
                {
                    // Empty strings are not allowed. Otherwise the WebSocket would listen for all events.
                    if (!empty($appName))
                    {
                        $ariWebSocketClient = new AriWebSocketClient($appName);
                        $ariWebSocketClient->publishWithAMQP();
                    }
                }
                break;
        }
    }
}