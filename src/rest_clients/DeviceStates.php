<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\rest_clients;


use AriStasisApp\models\DeviceState;

/**
 * Class DeviceStates
 *
 * @package AriStasisApp\rest_clients
 */
class DeviceStates extends AriRestClient
{
    /**
     * List all ARI controlled device states.
     *
     * @return DeviceState[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function list(): array
    {
        return $this->getRequest('/deviceStates', [], 'array', 'DeviceState');
    }

    /**
     * Retrieve the current state of a device.
     *
     * @param string $deviceName Name of the device
     * @return DeviceState|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function get(string $deviceName): DeviceState
    {
        return $this->getRequest("/deviceStates/{$deviceName}", [], 'model', 'DeviceState');
    }

    /**
     * Change the state of a device controlled by ARI. (Note - implicitly creates the device state).
     *
     * @param string $deviceName Name of the device
     * @param string $deviceState Allowed: NOT_INUSE, INUSE, BUSY, INVALID, UNAVAILABLE, RINGING, RINGINUSE, ONHOLD
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function update(string $deviceName, string $deviceState): void
    {
        $this->putRequest("/deviceStates/{$deviceName}", ['deviceState' => $deviceState]);
    }

    /**
     * Destroy a device-state controlled by ARI.
     *
     * @param string $deviceName Name of the device
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function delete(string $deviceName): void
    {
        $this->deleteRequest("/deviceStates/{$deviceName}");
    }
}