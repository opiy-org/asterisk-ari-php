<?php

require_once __DIR__ . '/vendor/autoload.php';

$client = new \AriStasisApp\rest_clients\Events('asterisk', 'asterisk');

$client->userEvent('customEventExample', 'ExampleLocalApp');