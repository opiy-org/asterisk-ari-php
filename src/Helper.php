<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

/**
 * Class Helper provides a collection of unsorted static functions for the library
 * components.
 *
 * @package OpiyOrg\AriClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class Helper
{
    /**
     * Create and configure a basic logger.
     *
     * @param string $name The name of the logger.
     *
     * @return LoggerInterface
     */
    public static function initLogger(string $name): LoggerInterface
    {
        $logger = new Logger($name);

        $stdOut = fopen('php://stdout', 'wb');
        $logger->pushHandler(new StreamHandler($stdOut, Logger::DEBUG));
        $logger->pushHandler(new StreamHandler($stdOut, Logger::INFO));
        $logger->pushHandler(new StreamHandler($stdOut, Logger::WARNING));
        $logger->pushHandler(new StreamHandler($stdOut, Logger::ERROR));

        return $logger;
    }
}
