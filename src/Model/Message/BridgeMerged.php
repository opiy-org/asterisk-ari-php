<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\Model\Message;


use AriStasisApp\Model\Bridge;

/**
 * Notification that one bridge has merged into another.
 *
 * @package AriStasisApp\Model\Message
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
    private $bridge_from;

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
        return $this->bridge_from;
    }

    /**
     * @param Bridge $bridgeFrom
     */
    public function setBridgeFrom(Bridge $bridgeFrom): void
    {
        $this->bridge_from = $bridgeFrom;
    }
}