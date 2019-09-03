<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Models\Message;

use NgVoice\AriClient\Models\DeviceState;

/**
 * Notification that a device state has changed.
 *
 * @package NgVoice\AriClient\Models\Message
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class DeviceStateChanged extends Event
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
