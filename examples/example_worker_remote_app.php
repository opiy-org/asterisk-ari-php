<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2019)
 *
 * The asterisk events will be received by a web socket client which then sends them to your API.
 * We recommend using supervisor to monitor this process in the background.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use NgVoice\AriClient\WebSocketClient\{RemoteAppMessageHandler, WebSocketClient};

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

$remoteApiSettings = [
    'httpsEnabled' => false,
    'host' => 'localhost',
    'port' => 8000,
    'rootUri' => '/api/asteriskEvents', // Sends events as JSON via 'PUT' to $rootUri."/{$ariAppName}/{$ariEventType}",
    'user' => 'myUserName',
    'password' => 'myPassword',
];

$exampleLocalApp = new ExampleLocalApp($ariUser, $ariPass);

$ariWebSocket = new WebSocketClient(
    ['ExampleLocalApp'],
    new RemoteAppMessageHandler($remoteApiSettings),
    $webSocketSettings
);

$ariWebSocket->start();