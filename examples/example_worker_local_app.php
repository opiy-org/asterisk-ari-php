<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2019)
 *
 * The asterisk events will be received by a web socket client which then is handled by your own local app.
 * We recommend using supervisor to monitor this process in the background.
 */

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/ExampleLocalApp.php';

use NgVoice\AriClient\WebSocketClient\{LocalAppMessageHandler, WebSocketClient};

/**
 * You will need to run a worker script like this one in the background to
 * keep the WebSocketClient connection up.
 * I prefer using 'supervisor' to monitor my worker processes.
 */

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

$exampleLocalApp = new ExampleLocalApp($ariUser, $ariPass);

$ariWebSocket = new WebSocketClient(
    ['ExampleLocalApp'],
    new LocalAppMessageHandler($exampleLocalApp),
    $webSocketSettings
);

$ariWebSocket->start();