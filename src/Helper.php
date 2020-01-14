<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient;

use Exception;
use Monolog\Handler\{NullHandler, StreamHandler};
use Monolog\Logger;

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
    private static ?bool $isInDebugMode = null;

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

        try {
            if (self::isInDebugMode()) {
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

    /**
     * Return a flag, indicating if the ARI client library components
     * are in debug mode.
     *
     * @return bool Flag, indicating if the ARI client
     * library components are in debug mode.
     */
    private static function isInDebugMode(): bool
    {
        if (self::$isInDebugMode !== null) {
            return self::$isInDebugMode;
        }

        $debugModeFile = fopen(__DIR__ . '/../debug_mode.yaml', 'rb');

        /**
         * @noinspection UnknownInspectionInspection The [EA] extension
         * doesn't know about the noinspection annotation.
         * @noinspection CallableInLoopTerminationConditionInspection File pointer
         * for fgetc() call is moved with every iteration.
         */
        for ($charPointer = -1; fgetc($debugModeFile) !== ':'; $charPointer--) {
            fseek($debugModeFile, $charPointer, SEEK_END);
        }

        $inDebugMode = trim(fgets($debugModeFile));
        fclose($debugModeFile);

        self::$isInDebugMode = $inDebugMode === 'true';

        return self::$isInDebugMode;
    }
}
