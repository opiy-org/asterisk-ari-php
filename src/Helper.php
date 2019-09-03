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
            echo 'Reflection of class' . get_class($object) . " failed.\n";
            echo $e->getMessage();
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
            $settings['debug_mode'] ?
                $logger->pushHandler(new StreamHandler(STDOUT, Logger::DEBUG))
                : $logger->pushHandler(new NullHandler(Logger::DEBUG));
            $logger->pushHandler(
                new StreamHandler(STDOUT, Logger::INFO)
            );
            $logger->pushHandler(
                new StreamHandler(STDOUT, Logger::WARNING)
            );
            $logger->pushHandler(
                new StreamHandler(STDERR, Logger::ERROR)
            );

            $logger->debug('Loggers have successfully been set');
        } catch (Exception $e) {
            fwrite(STDERR, "Error while setting up loggers: '{$e->getMessage()}'\n");
            exit(1);
        }

        return $logger;
    }
}
