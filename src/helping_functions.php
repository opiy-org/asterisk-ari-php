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
 * @param array $ariSettings
 * @return array
 */
function parseAriSettings(array $ariSettings)
{
    $ariSettings = array_merge([
        'httpsEnabled' => false,
        'host' => 'localhost',
        'port' => 8088,
        'rootUrl' => '/ari',
        'user' => 'asterisk',
        'password' => 'asterisk'
    ], $ariSettings);
    return $ariSettings;
}

/**
 * @param array $amqpSettings
 * @return array
 */
function parseAMQPSettings(array $amqpSettings)
{
    $amqpSettings = array_merge([
        'appName' => '',
        'host' => 'localhost',
        'port' => 5672,
        'user' => 'guest',
        'password' => 'guest',
        'vhost' => '/',
        'exchange' => 'asterisk'
    ], $amqpSettings);
    return $amqpSettings;
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