<?php

/**
 * @author Lukas Stermann
 * @author Rick Barenthin
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
    private $lastReloadTime;

    /**
     * @var string Time when Asterisk was started.
     */
    private $startupTime;

    /**
     * @return string
     */
    public function getLastReloadTime(): string
    {
        return $this->lastReloadTime;
    }

    /**
     * @param string $lastReloadTime
     */
    public function setLastReloadTime(string $lastReloadTime): void
    {
        $this->lastReloadTime = $lastReloadTime;
    }

    /**
     * @return string
     */
    public function getStartupTime(): string
    {
        return $this->startupTime;
    }

    /**
     * @param string $startupTime
     */
    public function setStartupTime(string $startupTime): void
    {
        $this->startupTime = $startupTime;
    }
}