<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp;


use Monolog\Handler\{NullHandler, StreamHandler};
use Monolog\Logger;
use ReflectionClass;
use Symfony\Component\Yaml\Yaml;

/**
 * @param array $array
 * @return string
 */
function glueArrayOfStrings(array $array): string
{
    $result = '';
    foreach ($array as $option) {
        $result = "{$result},{$option}";
    }
    return ltrim($result, ',');
}


/**
 * @return array
 */
function getAsteriskDefaultSettings(): array
{
    return [
        'host' => 'localhost',
        'port' => 8088,
        'rootUri' => '/ari',
        'user' => '',
        'password' => ''
    ];
}


/**
 * @param array $myApiSettings
 * @return array
 */
function parseMyApiSettings(array $myApiSettings): array
{
    return array_merge([
        'httpsEnabled' => false,
        'host' => 'localhost',
        'port' => 8000,
        'rootUri' => '/api/asteriskEvents',
        'user' => '',
        'password' => '',
    ], $myApiSettings);
}


/**
 * @param array $ariSettings
 * @return array
 */
function parseAriSettings(array $ariSettings): array
{
    return array_merge(
        array_merge(['httpsEnabled' => false], getAsteriskDefaultSettings()), $ariSettings);
}


/**
 * @param array $webSocketSettings
 * @return array
 */
function parseWebSocketSettings(array $webSocketSettings): array
{
    return array_merge(
        array_merge(['wssEnabled' => false], getAsteriskDefaultSettings()), $webSocketSettings);
}


/**
 * @param $object
 * @return string
 */
function getShortClassName($object): string
{
    try {
        $reflect = new ReflectionClass($object);
        return $reflect->getShortName();
    } catch (\ReflectionException $e) {
        print_r("Reflection of class {$object} failed. Terminating...", true);
        print_r($e->getMessage(), true);
        exit(1);
    }

}

/**
 * Create a log channel and set it up.
 *
 * @param string $name
 * @return Logger
 */
function initLogger(string $name): Logger
{
    $logger = new Logger($name);

    $settings = Yaml::parseFile(__DIR__ . '/../environment.yaml');

    try {
        $stdOutPath = 'php://stdout';
        $settings['app']['debugmode'] ?
            $logger->pushHandler(new StreamHandler($stdOutPath, Logger::DEBUG))
            : $logger->pushHandler(new NullHandler(Logger::DEBUG));
        $logger->pushHandler(
            new StreamHandler($stdOutPath, Logger::INFO));
        $logger->pushHandler(
            new StreamHandler($stdOutPath, Logger::WARNING));
        $logger->pushHandler(
            new StreamHandler('php://stderr', Logger::ERROR));

        $logger->debug('Loggers have successfully been set');
    } catch (\Exception $e) {
        print_r("Error while setting up loggers:\n", true);
        print_r($e->getMessage(), true);
        exit(1);
    }
    return $logger;
}