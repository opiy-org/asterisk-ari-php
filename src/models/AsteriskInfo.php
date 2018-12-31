<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models;


/**
 * Asterisk system information
 *
 * @package AriStasisApp\models
 */
class AsteriskInfo
{
    /**
     * @var StatusInfo Info about Asterisk status.
     */
    private $status;

    /**
     * @var ConfigInfo Info about Asterisk configuration.
     */
    private $config;

    /**
     * @var BuildInfo Info about how Asterisk was built.
     */
    private $build;

    /**
     * @var SystemInfo Info about the system running Asterisk.
     */
    private $system;

    /**
     * @return StatusInfo
     */
    public function getStatus(): StatusInfo
    {
        return $this->status;
    }

    /**
     * @param StatusInfo $status
     */
    public function setStatus(StatusInfo $status): void
    {
        $this->status = $status;
    }

    /**
     * @return ConfigInfo
     */
    public function getConfig(): ConfigInfo
    {
        return $this->config;
    }

    /**
     * @param ConfigInfo $config
     */
    public function setConfig(ConfigInfo $config): void
    {
        $this->config = $config;
    }

    /**
     * @return BuildInfo
     */
    public function getBuild(): BuildInfo
    {
        return $this->build;
    }

    /**
     * @param BuildInfo $build
     */
    public function setBuild(BuildInfo $build): void
    {
        $this->build = $build;
    }

    /**
     * @return SystemInfo
     */
    public function getSystem(): SystemInfo
    {
        return $this->system;
    }

    /**
     * @param SystemInfo $system
     */
    public function setSystem(SystemInfo $system): void
    {
        $this->system = $system;
    }
}