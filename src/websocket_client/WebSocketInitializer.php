<?php
/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 *
 */

namespace AriStasisApp\websocket_client;


/**
 * Class WebSocketInitializer
 *
 * @package AriStasisApp\websocket
 */
class WebSocketInitializer
{
    /**
     * @param array $appNames
     * @param array $asteriskSettings
     * @throws \Exception
     */
    static function startWebSocketsAndAMQPPublishers(array $appNames = [], array $asteriskSettings = [])
    {
        // TODO: Do we need a break; statement here every time?
        if ($appNames === []) {
            $ariWebSocketClient = new WebSocketClient($asteriskSettings);
            $ariWebSocketClient->publishWithAMQP();
        } else {
            foreach ($appNames as $appName)
            {
                print_r("AppName: ".$appName."\n");
                // Empty strings are not allowed. Otherwise the WebSocket would listen for all events.
                if ($appName !== '')
                {
                    $ariWebSocketClient = new WebSocketClient(
                        array_merge(['appName' => $appName], $asteriskSettings));
                    $ariWebSocketClient->publishWithAMQP();
                }
            }
        }
    }
}