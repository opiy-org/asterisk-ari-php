<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Client;

use InvalidArgumentException;
use Psr\Log\LoggerInterface;

/**
 * A collection of client settings for the client implementations within this library.
 *
 * @package NgVoice\AriClient\Client
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
abstract class AbstractSettings
{
    private string $user;

    private string $password;

    private string $host = '127.0.0.1';

    private int $port = 8088;

    private string $rootUri = '/ari';

    private bool $isInDebugMode = false;

    private ?LoggerInterface $loggerInterface = null;

    /**
     * Settings constructor.
     *
     * @param string $user Username for the Asterisk REST Interface
     * @param string $password Password for the ARI
     */
    public function __construct(
        string $user,
        string $password
    ) {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Get the Asterisk REST Interface user name.
     *
     * @return string The Asterisk REST Interface user name
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * Get the Asterisk REST Interface password.
     *
     * @return string The Asterisk REST Interface password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Get the hosts IP address or name of the Asterisk REST Interface host.
     *
     * @return string The hosts IP address or name of the Asterisk REST Interface host
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * Set the hosts IP address or name of the Asterisk REST Interface host.
     *
     * @param string The hosts IP address or name of the Asterisk REST Interface host
     */
    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    /**
     * Get the port on the Asterisk REST Interface host.
     *
     * @return int The port on the Asterisk REST Interface host
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * Set the port on the Asterisk REST Interface host.
     *
     * @param int $port The port on the Asterisk REST Interface host
     */
    public function setPort(int $port): void
    {
        if (($port > 65535) || ($port < 0)) {
            throw new InvalidArgumentException(
                'The port number has to be within range 0 - 65535'
            );
        }

        $this->port = $port;
    }

    /**
     * Get the root URI of the Asterisk REST Interface.
     *
     * @return string The root URI of the Asterisk REST Interface
     */
    public function getRootUri(): string
    {
        return $this->rootUri;
    }

    /**
     * Set the root URI of the Asterisk REST Interface.
     *
     * @param string $rootUri The root URI of the Asterisk REST Interface
     */
    public function setRootUri(string $rootUri): void
    {
        if (
            (strpos($rootUri, '/') === 0)
            && (strrpos($rootUri, '/') !== (strlen($rootUri) - 1))
        ) {
            $this->rootUri = $rootUri;
            return;
        }

        $errorMessage = sprintf(
            "Your root URI must start but not end with a slash character. Provided '%s'",
            $rootUri
        );

        throw new InvalidArgumentException($errorMessage);
    }

    /**
     * Check, if this client is in debug mode.
     *
     * @return bool Flag, indicating if this client
     * is in debug mode
     */
    public function isInDebugMode(): bool
    {
        return $this->isInDebugMode;
    }

    /**
     * Put the client into debug mode and therefore log debug messages.
     *
     * @param bool $isInDebugMode Flag, indicating if this client
     * is in debug mode
     */
    public function setIsInDebugMode(bool $isInDebugMode): void
    {
        $this->isInDebugMode = $isInDebugMode;
    }

    /**
     * Set the logger interface for this client.
     *
     * @param LoggerInterface|null $loggerInterface The logger for this client
     *
     * @return void
     */
    public function setLoggerInterface(?LoggerInterface $loggerInterface): void
    {
        $this->loggerInterface = $loggerInterface;
    }

    /**
     * Get the logger interface of this client.
     *
     * @return LoggerInterface|null The logger of this client
     */
    public function getLoggerInterface(): ?LoggerInterface
    {
        return $this->loggerInterface;
    }
}
