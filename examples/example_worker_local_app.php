<?php

/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 *
 * The asterisk events will be received by a web socket client which then is handled by your own local app.
 * We recommend using supervisor to monitor this process in the background.
 */

use AriStasisApp\websocket_client\WebSocketClient;

require_once __DIR__ . '/../vendor/autoload.php';

// User credentials
$ariUser = 'asterisk';
$ariPass = 'asterisk';

$webSocketSettings = [
    'wssEnabled' => false,
    'host' => 'localhost',
    'port' => 8088,
    'rootUri' => '/ari',
    'user' => $ariUser,
    'password' => $ariPass
];

$ariWebSocket = new WebSocketClient($webSocketSettings, 'ExampleLocalApp');
$ariWebSocket->runWithLocalApp(new ExampleLocalApp($ariUser, $ariPass));