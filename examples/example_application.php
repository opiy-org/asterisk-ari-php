<?php
/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 */

use AriStasisApp\http_client\EventsRestClient;

require_once '../vendor/autoload.php';

/**
 * Example for a usage in your application.
 *
 * READ FIRST:
 * Open two terminals and start
 * 'php example_ari_websocket ExampleStasisApp'
 * 'php example_ari_websocket AnotherStasisApp'
 * You cannot break anything while writing your own stasis app and do whatever you like.
 *
 */
// Start your http clients so it is easy to talk to ARI from your application.
$events = new EventsRestClient();
$events->userEvent('customEventExample', 'ExampleStasisApp');
$events->userEvent('customEventAnother', 'AnotherStasisApp');
