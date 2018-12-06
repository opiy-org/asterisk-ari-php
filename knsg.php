<?php

use AriStasisApp\AriClient;
use GuzzleHttp\Exception\GuzzleException;

require_once __DIR__ . '/vendor/autoload.php';


$ariClient = new AriClient('asterisk','asterisk');
$asteriskClient = $ariClient->getAsteriskClient();

try {
    // Get general information about your Asterisk.
    $asteriskInfo = $asteriskClient->getInfo();

    // Setting and getting an asterisk global variable
    $asteriskClient->setGlobalVar('exampleVariable', 'exampleValue');
    $variable = $asteriskClient->getGlobalVar('exampleVariable');

    $pjsipModule = $asteriskClient->getModule('pjsip');
}
catch (GuzzleException $guzzleException) {
    syslog(LOG_ERR, $guzzleException->getMessage());
}
catch (JsonMapper_Exception $jsonMapper_Exception) {
    syslog(LOG_ERR, $jsonMapper_Exception->getMessage());
}

echo $asteriskInfo->getStatus()->getStartupTime() . "\n";
echo $variable->getValue() . "\n";
//print_r($pjsipModule);


$as = 'AriStasisApp\models\Bridge';
$asTest = new $as();
print_r($asTest);