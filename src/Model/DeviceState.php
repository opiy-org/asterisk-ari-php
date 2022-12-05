<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model;

/**
 * Represents the state of a device.
 *
 * @package OpiyOrg\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class DeviceState implements ModelInterface
{
    public string $name;

    public string $state;

    /**
     * Name of the device.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Device's state.
     *
     * @see DeviceStates
     *
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }
}
