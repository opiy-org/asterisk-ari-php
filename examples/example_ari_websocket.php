<?php

/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 *
 * The asterisk events will be received by a web socket client which then sends them to your API.
 * We recommend using superviisor to monitor this process in the background.
 */

use AriStasisApp\websocket_client\WebSocketClient;

require_once __DIR__ . '../vendor/autoload.php';


if (!isset($argv[1])) {
    print_r("Please provide an application name as a script parameter.\n"
        . "It can also be an empty string, forcing your WebSocket to listen for all events from your asterisk.\n");
    exit(1);
} else {
    $appName = $argv[1];
}

$webSocketSettings = [
    'wssEnabled' => false,
    'host' => 'localhost',
    'port' => 8088,
    'rootUri' => '/ari',
    'user' => 'asterisk',
    'password' => 'asterisk'
];

$myApiSettings = [
    'httpsEnabled' => false,
    'host' => 'localhost',
    'port' => 8000,
    'webHookUri' => '/api/asteriskEvents'
    // TODO: Not implemented yet
    // 'user' => 'myUserName',
    // 'password' => 'myPassword',
    // 'apiKey' => 'myApiKey'
];

$ariWebSocket = new WebSocketClient($appName, $webSocketSettings, $myApiSettings);
$ariWebSocket->run();
