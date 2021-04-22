<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model\Message\Event;

use OpiyOrg\AriClient\Model\Bridge;

/**
 * Notification that the source of video in a bridge has changed.
 *
 * @package OpiyOrg\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class BridgeVideoSourceChanged extends Event
{
    private string $oldVideoSourceId;

    private Bridge $bridge;

    /**
     * The old video source id.
     *
     * @return string
     */
    public function getOldVideoSourceId(): string
    {
        return $this->oldVideoSourceId;
    }

    /**
     * The affected bridge.
     *
     * @return Bridge
     */
    public function getBridge(): Bridge
    {
        return $this->bridge;
    }
}
