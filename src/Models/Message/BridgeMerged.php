<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Models\Message;

use NgVoice\AriClient\Models\Bridge;

/**
 * Notification that one bridge has merged into another.
 *
 * @package NgVoice\AriClient\Models\Message
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class BridgeMerged extends Event
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
