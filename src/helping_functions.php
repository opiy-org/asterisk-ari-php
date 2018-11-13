<?php
/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 */
namespace AriStasisApp;

use ReflectionClass;
use Symfony\Component\Yaml\Yaml;
use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Create a log channel and set it up.
 *
 * @param string $name
 * @return Logger
 */
function initLogger(string $name)
{
    $logger = new Logger($name);

    $settings = Yaml::parseFile('../environment.yaml');

    try {
        $settings['app']['debugmode'] ?
            $logger->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG))
            : $logger->pushHandler(new NullHandler(Logger::DEBUG));

        $logger->pushHandler(
            new StreamHandler('php://stdout', Logger::INFO));
        $logger->pushHandler(
            new StreamHandler('php://stdout', Logger::WARNING));

        $logger->debug('Loggers have successfully been set');
    } catch (\Exception $e) {
        print_r("Error while setting up loggers:\n", true);
        print_r($e->getMessage(), true);
        exit(1);
    }
    return $logger;
}

/**
 * @param $object
 * @return string
 */
function getShortClassName($object)
{

    try{
        $reflect = new ReflectionClass($object);
        return $reflect->getShortName();
    }
    catch (\ReflectionException $e) {
        print_r("Reflection of class {$object} failed. Terminating...", true);
        print_r($e->getMessage(), true);
        exit(1);
    }
}