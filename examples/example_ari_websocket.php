<?php

/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 */

use AriStasisApp\websocket_client\WebSocketClient;

require_once '../vendor/autoload.php';


if (!$argv[1]) {
    print_r("Please provide an application name as a script parameter\n");
    exit(1);
}
else {
    $appName = $argv[1];
}

// Leave the array empty to let the WebSockets listen for all asterisk Events.
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

/**
 * The asterisk events will be received by a web socket client and then published to an ampq server (e.g RabbitMQ).
 * Implement your own consumers for the queues (name pattern is 'from-yourapplicationname-queue')
 * or (preferably) use your favorite framework like we do to handle amqp events :) e.g. Laravel
 */
$ariWebsocket = new WebSocketClient($appName, $webSocketSettings, $amqpSettings);
$ariWebsocket->run();
print_r('Success. Events will be provided to AMQP with '
    . "an own queue for the stasis application '{$appName}'.\n");

