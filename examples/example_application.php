<?php

/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 *
 * Example for usage in your application.
 *
 * TODO: READ FIRST!
 * Open two terminals and start
 * 'php example_ari_websocket.php ExampleStasisApp'
 * 'php example_ari_websocket.php AnotherStasisApp'
 */

use AriStasisApp\http_client\AsteriskRestClient;
use AriStasisApp\http_client\EventsRestClient;

require_once '../vendor/autoload.php';

// E.g. get your asterisk settings (This will not trigger stasis app events!)
$asterisk = new AsteriskRestClient();
$asteriskInfo = $asterisk->getInfo();

/*
 * This ARI client can generate custom user events for specific applications. Nice and simple to test your setup :)
 * The events will be published to your AMQP server.
 */
$events = new EventsRestClient();
$events->userEvent('customEventExample', 'ExampleStasisApp');
$events->userEvent('customEventAnother', 'AnotherStasisApp');
