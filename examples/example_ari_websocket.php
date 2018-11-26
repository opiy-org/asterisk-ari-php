<?php

/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 *
 * The asterisk events will be received by a web socket client and then published to an ampq server (e.g RabbitMQ).
 * Implement your own consumers for the queues (name of the queue that holds events from your stasis app is
 * 'yourapplicationname') or (preferably) use your favorite framework like we do to handle amqp events :) e.g. Laravel
 */

use AriStasisApp\websocket_client\WebSocketClient;

require_once '../vendor/autoload.php';


if (!isset($argv[1])) {
    print_r("Please provide an application name as a script parameter.\n"
        . "It can also be an empty string, forcing your WebSocket to listen for all events from your asterisk.\n");
    exit(1);
}
else {
    $appName = $argv[1];
}

$webSocketSettings = [
    'wssEnabled'    => false,
    'host'          => 'localhost',
    'port'          => 8088,
    'rootUri'       => '/ari',
    'user'          => 'asterisk',
    'password'      => 'asterisk'
];

$amqpSettings = [
    'host'      => 'localhost',
    'port'      => 5672,
    'user'      => 'guest',
    'password'  => 'guest',
    'vhost'     => '/',
    'exchange'  => 'asterisk'
];

$ariWebSocket = new WebSocketClient($appName, $webSocketSettings, $amqpSettings);
$ariWebSocket->run();
