<?php
/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 *
 * @OA\Info(
 *     title="Asterisk ARI Library",
 *     version="0.1",
 *     @OA\Contact(
 *         email="support@ng-voice.com"
 *     )
 * )
 *
 */

namespace AriStasisApp\ariclients;


/**
 * Class DeviceStatesClient
 *
 * @package AriStasisApp\ariclients
 */
class DeviceStatesClient extends AriClient
{
    /**
     * @OA\Get(
     *     path="/applications",
     *     @OA\Response(response="200", description="An example resource")
     * )
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function list()
    {
        return $this->getRequest('/deviceStates');
    }

    /**
     * @param string $deviceName
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function get(string $deviceName)
    {
        return $this->getRequest("/deviceStates/{$deviceName}");
    }

    /**
     * @param string $deviceName
     * @param string $deviceState Allowed: NOT_INUSE, INUSE, BUSY, INVALID, UNAVAILABLE, RINGING, RINGINUSE, ONHOLD
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function update(string $deviceName, string $deviceState)
    {
        return $this->putRequest("/deviceStates/{$deviceName}", ['deviceState' => $deviceState]);
    }

    /**
     * @param string $deviceName
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function delete(string $deviceName)
    {
        return $this->deleteRequest("/deviceStates/{$deviceName}");
    }
}