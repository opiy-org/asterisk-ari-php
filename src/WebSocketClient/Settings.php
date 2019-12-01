<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\WebSocketClient;

/**
 * Class Settings
 *
 * @package NgVoice\AriClient\WebSocketClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Settings
{
    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $password;

    /**
     * @var bool
     */
    private $wssEnabled = false;

    /**
     * @var string
     */
    private $host = '127.0.0.1';

    /**
     * @var int
     */
    private $port = 8088;

    /**
     * @var string
     */
    private $rootUri = '/ari';

    /**
     * Settings constructor.
     *
     * @param string $user The Asterisk ARI user
     * @param string $password The Asterisk ARI password
     */
    public function __construct(string $user, string $password)
    {
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
     * @return bool
     */
    public function isWssEnabled(): bool
    {
        return $this->wssEnabled;
    }

    /**
     * @param bool $wssEnabled
     */
    public function setWssEnabled(bool $wssEnabled): void
    {
        $this->wssEnabled = $wssEnabled;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
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
     * @param int $port
     */
    public function setPort(int $port): void
    {
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
     * @param string $rootUri
     */
    public function setRootUri(string $rootUri): void
    {
        $this->rootUri = $rootUri;
    }
}
