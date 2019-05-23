<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient;

use Exception;
use Monolog\Handler\{NullHandler, StreamHandler};
use Monolog\Logger;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Helper provides a collection of unsorted static functions for the library
 * components.
 *
 * @package NgVoice\AriClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Helper
{
    /**
     * Constructor and clone are private because objects
     * of this class shouldn't be instantiated.
     */
    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * Take an array of strings and convert it into
     * a single string with comma separated values.
     *
     * @param string[] $array An array with string values.
     *
     * @return string
     */
    public static function glueArrayOfStrings(array $array): string
    {
        $result = '';

        foreach ($array as $option) {
            $result = "{$result},{$option}";
        }

        return ltrim($result, ',');
    }

    /**
     * Get the short name of an objects class without the full namespace.
     *
     * @param object $object The object to get the class name from.
     *
     * @return string
     */
    public static function getShortClassName(object $object): string
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
     * Create and configure a basic logger.
     *
     * @param string $name The name of the logger.
     *
     * @return Logger
     */
    public static function initLogger(string $name): Logger
    {
        $logger = new Logger($name);

        $settings = Yaml::parseFile(__DIR__ . '/../debug_mode.yaml');

        try {
            $stdOutPath = 'php://stdout';

            $settings['debug_mode'] ?
                $logger->pushHandler(new StreamHandler($stdOutPath, Logger::DEBUG))
                : $logger->pushHandler(new NullHandler(Logger::DEBUG));
            $logger->pushHandler(
                new StreamHandler($stdOutPath, Logger::INFO)
            );
            $logger->pushHandler(
                new StreamHandler($stdOutPath, Logger::WARNING)
            );
            $logger->pushHandler(
                new StreamHandler('php://stderr', Logger::ERROR)
            );

            $logger->debug('Loggers have successfully been set');
        } catch (Exception $e) {
            print_r("Error while setting up loggers:\n", true);
            print_r($e->getMessage(), true);
            exit(1);
        }

        return $logger;
    }
}
