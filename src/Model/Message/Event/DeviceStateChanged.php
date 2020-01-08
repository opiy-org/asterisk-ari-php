<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Model\Message\Event;

use NgVoice\AriClient\Model\DeviceState;

/**
 * Notification that a device state has changed.
 *
 * @package NgVoice\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class DeviceStateChanged extends Event
{
    private DeviceState $deviceState;

    /**
     * Device state object.
     *
     * @return DeviceState
     */
    public function getDeviceState(): DeviceState
    {
        return $this->deviceState;
    }
}
