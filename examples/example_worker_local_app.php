<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 *
 * The asterisk events will be received by a web socket client which then is handled by your own local app.
 * We recommend using supervisor to monitor this process in the background.
 */

use AriStasisApp\websocket_client\{LocalAppMessageHandler, WebSocketClient};
use Symfony\Component\Yaml\Yaml;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/ExampleLocalApp.php';

/**
 * You will need to run a worker script like this one in the background to
 * keep the WebSocketClient connection up.
 * I prefer using 'supervisor' to monitor my worker processes.
 */

$settings = Yaml::parseFile(__DIR__ . '/../environment.yaml');

$webSocketSettings = [
    'wssEnabled' => false,
    'host' => 'localhost',
    'port' => 8088,
    'rootUri' => '/ari',
    'user' => $settings['tests']['asteriskUser'],
    'password' => $settings['tests']['asteriskPassword']
];

$exampleLocalApp = new ExampleLocalApp(
    $settings['tests']['asteriskUser'],
    $settings['tests']['asteriskPassword']
);

$ariWebSocket = new WebSocketClient(
    ['ExampleLocalApp'],
    new LocalAppMessageHandler($exampleLocalApp),
    $webSocketSettings
);

$ariWebSocket->start();