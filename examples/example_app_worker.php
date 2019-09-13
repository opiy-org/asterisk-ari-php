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
require_once __DIR__ . '/ExampleApp.php';

use NgVoice\AriClient\Helper;
use NgVoice\AriClient\RestClient\{Applications, AriRestClientSettings, Channels};
use NgVoice\AriClient\WebSocketClient\{AriFilteredMessageHandler,
    WebSocketClient,
    WebSocketSettings};

/**
 * You will need to run a worker script like this one in the background to
 * keep the WebSocketClient connection up.
 * I prefer using 'supervisor' to monitor my worker processes.
 */

$ariUser = 'asterisk';
$ariPass = 'asterisk';

$ariRestClientSettings = new AriRestClientSettings($ariUser, $ariPass);

$exampleApp = new ExampleApp(
    new Channels($ariRestClientSettings),
    Helper::initLogger('ExampleApp')
);

$ariWebSocket = new WebSocketClient(
    new WebSocketSettings($ariUser, $ariPass),
    $exampleApp,
    new AriFilteredMessageHandler($exampleApp, new Applications($ariRestClientSettings))
);

$ariWebSocket->start();
