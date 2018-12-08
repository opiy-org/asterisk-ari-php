<?php

use AriStasisApp\rest_clients\Asterisk;
use GuzzleHttp\Exception\GuzzleException;

require_once __DIR__ . '/vendor/autoload.php';

$asteriskClient = new Asterisk('asterisk', 'asterisk');

try {
    // Get general information about your Asterisk.
    $asteriskInfo = $asteriskClient->getInfo();

    // Setting and getting an asterisk global variable
    $asteriskClient->setGlobalVar('exampleVariable', 'exampleValue');
    $variable = $asteriskClient->getGlobalVar('exampleVariable');

    $pjsipModule = $asteriskClient->getModule('pjsip');
} catch (GuzzleException $guzzleException) {
    syslog(LOG_ERR, $guzzleException->getMessage());
}

echo $asteriskInfo->getStatus()->getStartupTime() . "\n";
echo $variable->getValue() . "\n";
//print_r($pjsipModule);


$as = 'AriStasisApp\models\Bridge';
$asTest = new $as();
print_r($asTest);