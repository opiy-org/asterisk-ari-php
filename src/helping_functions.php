<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient;


use Exception;
use Monolog\Handler\{NullHandler, StreamHandler};
use Monolog\Logger;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Yaml\Yaml;

/**
 * @param string[] $array
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
 * @param $object
 * @return string
 */
function getShortClassName($object): string
{
    try {
        $reflect = new ReflectionClass($object);
        return $reflect->getShortName();
    } catch (ReflectionException $e) {
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

    $settings = Yaml::parseFile(__DIR__ . '/../debugmode.yaml');

    try {
        $stdOutPath = 'php://stdout';
        $settings['debug_mode'] ?
            $logger->pushHandler(new StreamHandler($stdOutPath, Logger::DEBUG))
            : $logger->pushHandler(new NullHandler(Logger::DEBUG));
        $logger->pushHandler(
            new StreamHandler($stdOutPath, Logger::INFO));
        $logger->pushHandler(
            new StreamHandler($stdOutPath, Logger::WARNING));
        $logger->pushHandler(
            new StreamHandler('php://stderr', Logger::ERROR));

        $logger->debug('Loggers have successfully been set');
    } catch (Exception $e) {
        print_r("Error while setting up loggers:\n", true);
        print_r($e->getMessage(), true);
        exit(1);
    }
    return $logger;
}