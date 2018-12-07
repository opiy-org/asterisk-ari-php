<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 *
 * The asterisk events will be received by a web socket client which then is handled by your own local app.
 * We recommend using supervisor to monitor this process in the background.
 */

use AriStasisApp\websocket_client\WebSocketClient;
use Symfony\Component\Yaml\Yaml;

require_once __DIR__ . '/../vendor/autoload.php';

// User credentials
$settings = Yaml::parseFile(__DIR__ . '/../../environment.yaml');

$webSocketSettings = [
    'wssEnabled' => false,
    'host' => 'localhost',
    'port' => 8088,
    'rootUri' => '/ari',
    'user' => $settings['tests']['asteriskUser'],
    'password' => $settings['tests']['asteriskPassword']
];

$ariWebSocket = new WebSocketClient($webSocketSettings, 'ExampleLocalApp');
$ariWebSocket->runWithLocalApp(
    new ExampleLocalApp($settings['tests']['asteriskUser'], $settings['tests']['asteriskPassword'])
);