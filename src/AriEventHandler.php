<?php

namespace AriStasisApp;


use AriStasisApp\websocket_client\AriWebSocketClient;

/**
 * Class AriEventHandler
 *
 * @package AriStasisApp\websocket
 */
class AriEventHandler
{
    /**
     * @param array $appNames
     * @param array $asteriskSettings
     * @throws \Exception
     */
    static function startWebSocketsAndAMQPPublishers(array $appNames = [], array $asteriskSettings = [])
    {
        // TODO: Do we need a break; statement here every time?
        switch ($appNames){
            case []:
                $ariWebSocketClient = new AriWebSocketClient($asteriskSettings);
                $ariWebSocketClient->publishWithAMQP();
                break;

            default:
                foreach ($appNames as $appName)
                {
                    // Empty strings are not allowed. Otherwise the WebSocket would listen for all events.
                    if (!empty($appName))
                    {
                        $ariWebSocketClient = new AriWebSocketClient(
                            array_merge(['appName' => $appName], $asteriskSettings));
                        $ariWebSocketClient->publishWithAMQP();
                    }
                }
                break;
        }
    }
}