<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\RestClient;

/**
 * Class Settings encapsulates the settings for a ResourceClient.
 *
 * @package NgVoice\AriClient
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
    private $httpsEnabled = false;

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
     * @return bool
     */
    public function isHttpsEnabled(): bool
    {
        return $this->httpsEnabled;
    }

    /**
     * @param bool $httpsEnabled If HTTPS is enabled in ARI
     */
    public function setHttpsEnabled(bool $httpsEnabled): void
    {
        $this->httpsEnabled = $httpsEnabled;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host Host of ARI
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
     * @param string $rootUri The default uri root path.
     */
    public function setRootUri(string $rootUri): void
    {
        $this->rootUri = $rootUri;
    }
}
