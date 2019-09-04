<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\WebSocketClient;

/**
 * Class WebSocketSettings
 *
 * @package NgVoice\AriClient\WebSocketClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class WebSocketSettings
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
    private $wssEnabled;

    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    /**
     * @var string
     */
    private $rootUri;

    /**
     * WebSocketSettings constructor.
     *
     * @param string $user Username
     * @param string $password Password
     * @param bool $wssEnabled Check Websocket Enabled/Disabled
     * @param string $host Host Address
     * @param int $port Port Name
     * @param string $rootUri Root URI
     */
    public function __construct(
        string $user,
        string $password,
        bool $wssEnabled = false,
        string $host = '127.0.0.1',
        int $port = 8088,
        string $rootUri = '/ari'
    ) {
        $this->user = $user;
        $this->password = $password;
        $this->wssEnabled = $wssEnabled;
        $this->host = $host;
        $this->port = $port;
        $this->rootUri = $rootUri;
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
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getRootUri(): string
    {
        return $this->rootUri;
    }
}
