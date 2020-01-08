<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Model\Message\Event;

use NgVoice\AriClient\Model\Bridge;

/**
 * Notification that one bridge has merged into another.
 *
 * @package NgVoice\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class BridgeMerged extends Event
{
    private Bridge $bridge;

    private Bridge $bridgeFrom;

    /**
     * @return Bridge
     */
    public function getBridge(): Bridge
    {
        return $this->bridge;
    }

    /**
     * @return Bridge
     */
    public function getBridgeFrom(): Bridge
    {
        return $this->bridgeFrom;
    }
}
