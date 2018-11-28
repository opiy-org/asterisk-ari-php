<?php
/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\http_client;


/**
 * Class SoundsRestClient
 *
 * @package AriStasisApp\ariclients
 */
class SoundsRestClient extends AriRestClient
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