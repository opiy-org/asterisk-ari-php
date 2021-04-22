<?php

/**
 * @copyright 2020 ng-voice GmbH
 *
 * A web socket client receives the ARI events which then are handled by your own local
 * application class. You will need to run a worker script like this one to keep the
 * web socket connection up.
 *
 * We recommend using 'supervisor' to monitor the process in the background.
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/MyExampleStasisApp.php';

use OpiyOrg\AriClient\Client\Rest\Resource\{Channels as AriChannelsRestResourceClient,
    Events as AriEventsResourceRestClient};
use OpiyOrg\AriClient\Client\Rest\Settings as AriRestClientSettings;
use OpiyOrg\AriClient\Client\WebSocket\{Factory as AriWebSocketClientFactory,
    Settings as AriWebSocketClientSettings};

//////////////////////////////////////////////////////////////////////////////////////////

$ariRestClientSettings = new AriRestClientSettings('asterisk', 'asterisk');

$myExampleStasisApp = new MyExampleStasisApp(
    new AriChannelsRestResourceClient($ariRestClientSettings)
);

$ariWebSocketClientSettings = new AriWebSocketClientSettings(
    $ariRestClientSettings->getUser(),
    $ariRestClientSettings->getPassword()
);

/**
 * Optionally you can pass an error handler, which handles any uncaught Throwable that
 * is thrown within your defined ARI event handler functions. These are the functions
 * in your Stasis application class which start with the 'onAriEvent...' prefix.
 *
 * @see MyExampleStasisApp::onAriEventChannelUserevent()
 *
 * This handler is the last handler for Throwables before the process error handler
 * is called. Be aware that not handling Throwables will cause the process to die,
 * effectively killing the web socket connection. Any ARI event waiting in the queue
 * will therefore get lost.
 */
$ariWebSocketClientSettings->setErrorHandler(
    static function (string $context, Throwable $throwable) {
        printf(
            "\n\nThis is the error handler, triggered in context '%s'. "
            . "Throwable message: '%s'\n\n",
            $context,
            $throwable->getMessage()
        );
    }
);

$ariWebSocketClient = AriWebSocketClientFactory::create(
    $ariWebSocketClientSettings,
    $myExampleStasisApp
);

$ariEventsRestClient = new AriEventsResourceRestClient($ariRestClientSettings);

// Trigger an example ChannelUserevent every few seconds to see terminal output
$ariWebSocketClient->getLoop()->addPeriodicTimer(
    3,
    static function () use ($ariEventsRestClient) {
        $ariEventsRestClient->userEvent(
            'ThisEventIsTriggeredByYourself',
            'MyExampleStasisApp'
        );
    }
);

// After finishing configuration, start the web socket client.
$ariWebSocketClient->start();
