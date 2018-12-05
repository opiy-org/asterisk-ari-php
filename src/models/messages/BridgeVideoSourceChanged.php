<?php
/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models\messages;


use AriStasisApp\models\Bridge;

/**
 * Notification that the source of video in a bridge has changed.
 *
 * @package AriStasisApp\models\messages
 */
class BridgeVideoSourceChanged extends Event
{
    /**
     * @var string
     */
    private $oldVideoSourceId;

    /**
     * @var Bridge
     */
    private $bridge;

    /**
     * @return string
     */
    public function getOldVideoSourceId(): string
    {
        return $this->oldVideoSourceId;
    }

    /**
     * @param string $oldVideoSourceId
     */
    public function setOldVideoSourceId(string $oldVideoSourceId): void
    {
        $this->oldVideoSourceId = $oldVideoSourceId;
    }

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