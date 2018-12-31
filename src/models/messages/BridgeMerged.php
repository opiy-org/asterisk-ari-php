<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models\messages;


use AriStasisApp\models\Bridge;

/**
 * Notification that one bridge has merged into another.
 *
 * @package AriStasisApp\models\messages
 */
class BridgeMerged extends Event
{
    /**
     * @var Bridge
     */
    private $bridge;

    /**
     * @var Bridge
     */
    private $bridgeFrom;

    /**
     * @return Bridge
     */
    public function getBridge(): Bridge
    {
        return $this->bridge;
    }

    /**
     * @param Bridge $bridge
     */
    public function setBridge(Bridge $bridge): void
    {
        $this->bridge = $bridge;
    }

    /**
     * @return Bridge
     */
    public function getBridgeFrom(): Bridge
    {
        return $this->bridgeFrom;
    }

    /**
     * @param Bridge $bridgeFrom
     */
    public function setBridgeFrom(Bridge $bridgeFrom): void
    {
        $this->bridgeFrom = $bridgeFrom;
    }
}