<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models\messages;


use AriStasisApp\models\DeviceState;

/**
 * Notification that a device state has changed.
 *
 * @package AriStasisApp\models\messages
 */
class DeviceStateChanged extends Event
{
    /**
     * @var DeviceState Device state object.
     */
    private $device_state;

    /**
     * @return DeviceState
     */
    public function getDeviceState(): DeviceState
    {
        return $this->device_state;
    }

    /**
     * @param DeviceState $deviceState
     */
    public function setDeviceState(DeviceState $deviceState): void
    {
        $this->device_state = $deviceState;
    }
}