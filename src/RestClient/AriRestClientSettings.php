<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2019)
 */

namespace NgVoice\AriClient\RestClient;


/**
 * Class AriRestClientSettings
 * @package NgVoice\AriClient
 */
class AriRestClientSettings
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
     * @param string $ariUser
     * @param string $ariPassword
     * @param bool $httpsEnabled
     * @param string $host
     * @param int $port
     * @param string $rootUri
     */
    public function __construct(
        string $ariUser,
        string $ariPassword,
        bool $httpsEnabled = false,
        string $host = '172.0.0.1',
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