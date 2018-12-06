<?php

/**
 * @author Lukas Stermann
 * @author Rick Barenthin
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

namespace AriStasisApp\rest_clients;


use AriStasisApp\models\DeviceState;
use JsonMapper_Exception;

/**
 * Class DeviceStates
 *
 * @package AriStasisApp\ariclients
 */
class DeviceStates extends AriRestClient
{
    /**
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface TODO: List[DeviceState]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function list()
    {
        return $this->getRequest('/deviceStates');
    }

    /**
     * @param string $deviceName
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws JsonMapper_Exception
     */
    function get(string $deviceName): DeviceState
    {
        $response = $this->getRequest("/deviceStates/{$deviceName}");
        return $this->jsonMapper->map(json_decode($response->getBody()), new DeviceState());
    }

    /**
     * @param string $deviceName
     * @param string $deviceState Allowed: NOT_INUSE, INUSE, BUSY, INVALID, UNAVAILABLE, RINGING, RINGINUSE, ONHOLD
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function update(string $deviceName, string $deviceState): void
    {
        $this->putRequest("/deviceStates/{$deviceName}", ['deviceState' => $deviceState]);
    }

    /**
     * @param string $deviceName
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function delete(string $deviceName): void
    {
        $this->deleteRequest("/deviceStates/{$deviceName}");
    }
}