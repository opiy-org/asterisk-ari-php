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
 * Class SoundsClient
 *
 * @package AriStasisApp\ariclients
 */
class SoundsClient extends AriClient
{
    /**
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function list()
    {
        return $this->getRequest('/sounds');
    }

    /**
     * @param string $soundId
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function get(string $soundId)
    {
        return $this->getRequest("/sounds/{$soundId}");
    }
}