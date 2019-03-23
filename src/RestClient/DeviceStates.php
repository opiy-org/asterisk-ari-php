<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\RestClient;


use GuzzleHttp\Exception\GuzzleException;
use NgVoice\AriClient\Model\DeviceState;

/**
 * Class DeviceStates
 * @package NgVoice\AriClient\RestClient
 */
class DeviceStates extends AriRestClient
{
    /**
     * List all ARI controlled device states.
     *
     * @return DeviceState[]
     * @throws GuzzleException
     */
    public function list(): array
    {
        return $this->getRequest('/deviceStates', [], parent::ARRAY, DeviceState::class);
    }

    /**
     * Retrieve the current state of a device.
     *
     * @param string $deviceName Name of the device
     * @return DeviceState|object
     * @throws GuzzleException
     */
    public function get(string $deviceName): DeviceState
    {
        return $this->getRequest("/deviceStates/{$deviceName}", [], parent::MODEL, DeviceState::class);
    }

    /**
     * Change the state of a device controlled by ARI. (Note - implicitly creates the device state).
     *
     * @param string $deviceName Name of the device
     * @param string $deviceState Allowed: NOT_INUSE, INUSE, BUSY, INVALID, UNAVAILABLE, RINGING, RINGINUSE, ONHOLD
     * @throws GuzzleException
     */
    public function update(string $deviceName, string $deviceState): void
    {
        $this->putRequest("/deviceStates/{$deviceName}", ['deviceState' => $deviceState]);
    }

    /**
     * Destroy a device-state controlled by ARI.
     *
     * @param string $deviceName Name of the device
     * @throws GuzzleException
     */
    public function delete(string $deviceName): void
    {
        $this->deleteRequest("/deviceStates/{$deviceName}");
    }
}