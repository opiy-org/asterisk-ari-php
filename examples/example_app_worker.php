<?php

/**
 * @copyright 2019 ng-voice GmbH
 *
 * The asterisk events will be received by a web socket client which then is
 * handled by your own local app.
 * We recommend using supervisor to monitor this process in the background.
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/MyExampleStasisApp.php';

use NgVoice\AriClient\RestClient\{AriRestClientSettings, Channels};
use NgVoice\AriClient\WebSocketClient\{WebSocketClient, WebSocketClientSettings};

/**
 * You will need to run a worker script like this one in the background to
 * keep the WebSocketClient connection up.
 * I prefer using 'supervisor' to monitor my worker processes.
 */

$ariRestClientSettings = new AriRestClientSettings('asterisk', 'asterisk');

$myExampleStasisApp = new MyExampleStasisApp(new Channels($ariRestClientSettings));

$ariWebSocketClientSettings = new WebSocketClientSettings(
    $ariRestClientSettings->getAriUser(),
    $ariRestClientSettings->getAriPassword()
);

$ariWebSocketClient = new WebSocketClient(
    $ariWebSocketClientSettings,
    $myExampleStasisApp
);

$ariWebSocketClient->start();
