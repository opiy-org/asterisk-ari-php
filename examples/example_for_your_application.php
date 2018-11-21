<?php
/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 */

use AriStasisApp\http_client\{
    EventsRestClient,
    RecordingsRestClient,
    ChannelsRestClient,
    AsteriskRestClient,
    BridgesRestClient};
use AriStasisApp\websocket_client\WebSocketInitializer;

require_once '../vendor/autoload.php';

/**
 * ExampleAriApplication
 *
 * You cannot break anything while writing your own stasis app and do whatever you like.
 *
 */
// Starts your http clients so it is easy to talk to ARI from your application.
$recordings = new RecordingsRestClient();
$channels = new ChannelsRestClient();
$asterisk = new AsteriskRestClient();
$bridges = new BridgesRestClient();
$events = new EventsRestClient();

/*
 * If you want like, also start a WebSocket connection to asterisk to listen for certain events.
 * These events will be passed on to an ampq server (e.g RabbitMQ).
 * Implement your own consumers for the queues (name pattern is 'from-yourapplication-queue')
 */
try {
    // Leave the array empty to let the WebSockets listen for all asterisk Events.
    WebSocketInitializer::startWebSocketsAndAMQPPublishers(['ExampleStasisApplication', 'AnotherApplication']);
    print_r('WebSocket is running and listening for events. Events will be provided to AMQP with an own queue '
        . "for every stasis application\n");
}
catch (Exception $e) {
    echo "Exception occured: {$e->getMessage()}";
    exit(1);
}

//$recordings->listStored();

//$channels->originate('SIP/Alice',['app' => 'ExampleStasisApplication']);
//$channels->sendDtmf('channel123',"34545");
//$asterisk->setGlobalVar('peter','eeee');
//$asterisk->getGlobalVar('peter');
//$channels = $channels->list();
//$asteriskInfo = $asterisk->getInfo();
//$bridges = $bridges->list();
//$events->userEvent('customEventName1', 'ExampleStasisApplication');
$events->userEvent('customEventName2', 'ExampleStasisApplication');
