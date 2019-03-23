<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\Model;


/**
 * Represents the state of a device.
 *
 * @package AriStasisApp\Model
 */
class DeviceState
{
    /**
     * @var string Name of the device.
     */
    private $name;

    /**
     * @var string Device's state
     * ("UNKNOWN", "NOT_INUSE", "INUSE", "BUSY", "INVALID", "UNAVAILABLE", "RINGING", "RINGINUSE", "ONHOLD").
     */
    private $state;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState(string $state): void
    {
        $this->state = $state;
    }

}