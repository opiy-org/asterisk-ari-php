<?php
/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 */

use AriStasisApp\AriManager;
use AriStasisApp\AriEventHandler;

require_once '../vendor/autoload.php';

/**
 * Class ExampleAriApplication
 *
 * You cannot break anything while writing your own stasis app and do whatever you like.
 *
 */
// Starts your ARI manager, so it is easy to talk to ARI from your application.
$ariManager = new AriManager();

try {
    // Leave the array empty to let the WebSockets listen for all asterisk Events.
    AriEventHandler::startWebSocketsAndAMQPPublishers(['ExampleStasisApplication', 'AnotherApplication']);
    $ariManager->logger()->info(
        'WebSocket is running and listening for events. Events will be provided to AMQP with an own queue '
        . 'for every stasis application');
}
catch (Exception $e) {
    $ariManager->logger()->error($e->getMessage(),true);
    exit(1);
}

$ariManager->recordings()->listStored();

$ariManager->logger()->info("Calling Alice...");
$ariManager->channels()->originate('SIP/Alice');

$channels = $ariManager->channels()->list();
$ariManager->logger()->debug("Channels on Asterisk: {$channels}");

$asteriskInfo = $ariManager->asterisk()->getInfo();
$ariManager->logger()->info("Asterisk Info: {$asteriskInfo}");

$bridges = $ariManager->bridges()->list();
$ariManager->logger()->info("All bridges on Asterisk: {$bridges}");
$ariManager->logger()->info("Terminated");