<?php

/**
 * @author Lukas Stermann
 * @author Rick Barenthin
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
    private $deviceState;

    /**
     * @return DeviceState
     */
    public function getDeviceState(): DeviceState
    {
        return $this->deviceState;
    }

    /**
     * @param DeviceState $deviceState
     */
    public function setDeviceState(DeviceState $deviceState): void
    {
        $this->deviceState = $deviceState;
    }
}