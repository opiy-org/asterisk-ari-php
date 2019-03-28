<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\Model\Message;


use NgVoice\AriClient\Model\Bridge;

/**
 * Notification that a bridge has been destroyed.
 *
 * @package NgVoice\AriClient\Model\Message
 */
class BridgeDestroyed extends Event
{
    /**
     * @var \NgVoice\AriClient\Model\Bridge
     */
    private $bridge;

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
}