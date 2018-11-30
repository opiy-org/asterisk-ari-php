<?php

/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 *
 * Example for usage in your application.
 *
 * TODO: READ FIRST!
 * Open two terminals and start two processes, to recieve the two asterisk events.
 * 'php example_ari_websocket.php ExampleStasisApp'
 * 'php example_ari_websocket.php AnotherStasisApp'
 */

use AriStasisApp\rest_clients\Asterisk;
use AriStasisApp\rest_clients\Events;

require_once __DIR__ . '/../vendor/autoload.php';

// E.g. get your asterisk settings (This will not trigger stasis app events!)
(new Asterisk())->getInfo();

/*
 * This ARI client can generate custom user events for specific applications. Nice and simple to test your setup :)
 * The events will be published to your AMQP server.
 */
$events = new Events();
$events->userEvent('customEventExample', 'ExampleStasisApp');
$events->userEvent('customEventAnother', 'AnotherStasisApp');
