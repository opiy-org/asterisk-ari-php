<?php

/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 *
 * Example for usage in your application.
 *
 * TODO: READ FIRST!
 * Open a terminals and start the example WebSocketClient script, to recieve the asterisk user event.
 * 'php example_ari_websocket.php ExampleStasisApp'
 */

use AriStasisApp\AriClient;
use GuzzleHttp\Exception\GuzzleException;

require_once __DIR__ . '/../vendor/autoload.php';

$ariClient = new AriClient('asterisk', 'asterisk');
$asterikClient = $ariClient->getAsteriskClient();
$eventsClient = $ariClient->getEventsClient();

try {
    // E.g. get your asterisk settings (This will not trigger stasis app events!)
    $asterikClient->getInfo();

    /*
     * This ARI client can generate custom user events for specific applications. Nice and simple to test your setup :)
     * The events will be published to your AMQP server.
     */
    $eventsClient->userEvent('customEventExample', 'ExampleStasisApp');
}
catch (GuzzleException $guzzleException) {
    print_r($guzzleException->getMessage());
}
catch (JsonMapper_Exception $jsonMapper_Exception) {
    print_r($jsonMapper_Exception->getMessage());
}