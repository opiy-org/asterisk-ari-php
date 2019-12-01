<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient;

use Exception;
use Monolog\Handler\{NullHandler, StreamHandler};
use Monolog\Logger;
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
     * Get the short name of an objects class without the full namespace.
     *
     * @param object $object The object to get the class name from.
     *
     * @return string
     */
    public static function getShortClassName(object $object): string
    {
        $fullPathClassName = explode('\\', get_class($object));

        return (string) end($fullPathClassName);
    }

    /**
     * Create and configure a basic logger.
     *
     * @param string $name The name of the logger.
     *
     * @param Logger|null $logger The logger to initialize
     *
     * @return Logger
     */
    public static function initLogger(
        string $name,
        Logger $logger = null
    ): Logger {
        if ($logger === null) {
            $logger = new Logger($name);
        }

        $absoluteFilePath = __DIR__ . '/../debug_mode.yaml';

        try {
            $settings = Yaml::parseFile($absoluteFilePath);

            if ($settings['debug_mode']) {
                $logger->pushHandler(new StreamHandler(STDOUT, Logger::DEBUG));
            } else {
                $logger->pushHandler(new NullHandler(Logger::DEBUG));
            }

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
            trigger_error($e->getMessage(), E_USER_ERROR);
            // Filenames hard coded, hence there is no chance to throw an exception here.
        }

        return $logger;
    }
}
