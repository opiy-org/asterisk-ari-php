<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models;


/**
 * Info about Asterisk status.
 *
 * @package AriStasisApp\models
 */
class StatusInfo
{
    /**
     * @var string Time when Asterisk was last reloaded.
     */
    private $last_reload_time;

    /**
     * @var string Time when Asterisk was started.
     */
    private $startup_time;

    /**
     * @return string
     */
    public function getLastReloadTime(): string
    {
        return $this->last_reload_time;
    }

    /**
     * @param string $last_reload_time
     */
    public function setLastReloadTime(string $last_reload_time): void
    {
        $this->last_reload_time = $last_reload_time;
    }

    /**
     * @return string
     */
    public function getStartupTime(): string
    {
        return $this->startup_time;
    }

    /**
     * @param string $startup_time
     */
    public function setStartupTime(string $startup_time): void
    {
        $this->startup_time = $startup_time;
    }
}