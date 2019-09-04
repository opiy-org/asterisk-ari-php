<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\RestClient;

/**
 * Class AriRestClientSettings encapsulates the settings for a AriClient.
 *
 * @package NgVoice\AriClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class AriRestClientSettings
{
    /**
     * @var string
     */
    private $ariUser;

    /**
     * @var string
     */
    private $ariPassword;

    /**
     * @var bool
     */
    private $httpsEnabled;

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
     * AriRestClientSettings constructor.
     *
     * @param string $ariUser Username for the AriRestClient
     * @param string $ariPassword Password for the AriRestClient
     * @param bool $httpsEnabled Check if httpsEnabled
     * @param string $host Host Address for AriRestClient
     * @param int $port Port Name for AriRestClient
     * @param string $rootUri Root URI for AriRestClient
     */
    public function __construct(
        string $ariUser,
        string $ariPassword,
        bool $httpsEnabled = false,
        string $host = '127.0.0.1',
        int $port = 8088,
        string $rootUri = '/ari'
    ) {
        $this->ariUser = $ariUser;
        $this->ariPassword = $ariPassword;
        $this->httpsEnabled = $httpsEnabled;
        $this->host = $host;
        $this->port = $port;
        $this->rootUri = $rootUri;
    }

    /**
     * @return string
     */
    public function getAriUser(): string
    {
        return $this->ariUser;
    }

    /**
     * @return string
     */
    public function getAriPassword(): string
    {
        return $this->ariPassword;
    }

    /**
     * @return bool
     */
    public function isHttpsEnabled(): bool
    {
        return $this->httpsEnabled;
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
