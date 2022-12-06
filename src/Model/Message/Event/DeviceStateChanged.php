<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model\Message\Event;

use OpiyOrg\AriClient\Model\DeviceState;

/**
 * Notification that a device state has changed.
 *
 * @package OpiyOrg\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class DeviceStateChanged extends Event
{
    public DeviceState $deviceState;

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
