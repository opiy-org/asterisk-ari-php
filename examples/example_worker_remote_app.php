<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 *
 * The asterisk events will be received by a web socket client which then sends them to your API.
 * We recommend using supervisor to monitor this process in the background.
 */

use AriStasisApp\websocket_client\WebSocketClient;
use Symfony\Component\Yaml\Yaml;

require_once __DIR__ . '/../vendor/autoload.php';

$settings = Yaml::parseFile(__DIR__ . '/../environment.yaml');

$webSocketSettings = [
    'wssEnabled' => false,
    'host' => 'localhost',
    'port' => 8088,
    'rootUri' => '/ari',
    'user' => $settings['tests']['asteriskUser'],
    'password' => $settings['tests']['asteriskPassword']
];

$remoteApiSettings = [
    'httpsEnabled' => false,
    'host' => 'localhost',
    'port' => 8000,
    'rootUri' => '/api/asteriskEvents',
    'user' => 'myUserName',
    'password' => 'myPassword',
];

$ariWebSocket = new WebSocketClient(['ExampleRemoteApp'], $webSocketSettings, true);
$ariWebSocket->runWithRemoteApp($remoteApiSettings);