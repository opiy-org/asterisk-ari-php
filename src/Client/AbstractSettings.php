<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Client;

use InvalidArgumentException;

/**
 * A collection of client settings for the client implementations within this library.
 *
 * @package NgVoice\AriClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
abstract class AbstractSettings
{
    /**
     * The Asterisk user name
     */
    private string $user;

    /**
     * The Asterisk user password
     */
    private string $password;

    /**
     * The hosts IP address or name of the Asterisk REST Interface host
     */
    private string $host = '127.0.0.1';

    /**
     * The port on the Asterisk REST Interface host
     */
    private int $port = 8088;

    /**
     * The root URI of the Asterisk REST Interface
     */
    private string $rootUri = '/ari';

    /**
     * Settings constructor.
     *
     * @param string $user Username for the ARI
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
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host @see property $host
     */
    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @param int $port Port of ARI
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
     * @return string
     */
    public function getRootUri(): string
    {
        return $this->rootUri;
    }

    /**
     * @param string $rootUri The default URI root path.
     */
    public function setRootUri(string $rootUri): void
    {
        if (
            (strpos($rootUri, '/') !== 0)
            || (strrpos($rootUri, '/') === (strlen($rootUri) - 1))
        ) {
            throw new InvalidArgumentException(
                'Your root URI must start but not end with a slash character'
            );
        }

        $this->rootUri = $rootUri;
    }
}
