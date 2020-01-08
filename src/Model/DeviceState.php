<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Model;

/**
 * Represents the state of a device.
 *
 * @package NgVoice\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class DeviceState implements ModelInterface
{
    private string $name;

    private string $state;

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
