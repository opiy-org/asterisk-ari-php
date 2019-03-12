<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 *
 * The asterisk events will be received by a web socket client which then sends them to your API.
 * We recommend using supervisor to monitor this process in the background.
 */

use AriStasisApp\websocket_client\{RemoteAppMessageHandler, WebSocketClient};
use Symfony\Component\Yaml\Yaml;

require_once __DIR__ . '/../vendor/autoload.php';

$settings = Yaml::parseFile(__DIR__ . '/../environment.yaml');
$user = $settings['tests']['asteriskUser'];
$password = $settings['tests']['asteriskPassword'];

$webSocketSettings = [
    'wssEnabled' => false,
    'host' => 'localhost',
    'port' => 8088,
    'rootUri' => '/ari',
    'user' => $user,
    'password' => $password
];

$remoteApiSettings = [
    'httpsEnabled' => false,
    'host' => 'localhost',
    'port' => 8000,
    'rootUri' => '/api/asteriskEvents', // Sends events as JSON via 'PUT' to $rootUri."/{$ariAppName}/{$ariEventType}",
    'user' => 'myUserName',
    'password' => 'myPassword',
];

$exampleLocalApp = new ExampleLocalApp($user, $password);

$ariWebSocket = new WebSocketClient(
    ['ExampleLocalApp'],
    new RemoteAppMessageHandler($remoteApiSettings),
    $webSocketSettings
);

$ariWebSocket->start();