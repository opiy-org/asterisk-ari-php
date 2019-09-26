<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\RestClient;

use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use NgVoice\AriClient\Models\DeviceState;

/**
 * An implementation of the DeviceStates REST client for the
 * Asterisk REST Interface
 *
 * @see https://wiki.asterisk.org/wiki/display/AST/Asterisk+16+DeviceStates+REST+API
 *
 * @package NgVoice\AriClient\RestClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class DeviceStates extends AsteriskRestInterfaceClient
{
    public const NOT_INUSE = 'NOT_INUSE';

    public const INUSE = 'INUSE';

    public const BUSY = 'BUSY';

    public const INVALID = 'INVALID';

    public const UNAVAILABLE = 'UNAVAILABLE';

    public const RINGING = 'RINGING';

    public const RING_INUSE = 'RINGINUSE';

    public const ON_HOLD = 'ONHOLD';

    /**
     * List all ARI controlled device states.
     *
     * @return DeviceState[]
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function list()
    {
        /** @var DeviceState[] $deviceStates */
        $deviceStates = $this->requestGetArrayOfModels(
            DeviceState::class,
            '/deviceStates'
        );

        return $deviceStates;
    }

    /**
     * Retrieve the current state of a device.
     *
     * @param string $deviceName Name of the device
     *
     * @return DeviceState
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function get(string $deviceName): DeviceState
    {
        /** @var DeviceState $deviceState */
        $deviceState = $this->getModelRequest(
            DeviceState::class,
            "/deviceStates/{$deviceName}"
        );

        return $deviceState;
    }

    /**
     * Change the state of a device controlled by ARI. (Note - implicitly creates the
     * device state).
     *
     * @param string $deviceName Name of the device
     * @param string $deviceState Allowed: NOT_INUSE, INUSE, BUSY, INVALID, UNAVAILABLE,
     *     RINGING, RINGINUSE, ONHOLD
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function update(string $deviceName, string $deviceState): void
    {
        $this->putRequest(
            "/deviceStates/{$deviceName}",
            ['deviceState' => $deviceState]
        );
    }

    /**
     * Destroy a device-state controlled by ARI.
     *
     * @param string $deviceName Name of the device
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function delete(string $deviceName): void
    {
        $this->deleteRequest("/deviceStates/{$deviceName}");
    }
}
