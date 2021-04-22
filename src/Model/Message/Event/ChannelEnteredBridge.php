<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model\Message\Event;

use OpiyOrg\AriClient\Model\{Bridge, Channel};

/**
 * Notification that a channel has entered a bridge.
 *
 * @package OpiyOrg\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ChannelEnteredBridge extends Event
{
    private Channel $channel;

    private Bridge $bridge;

    /**
     * @return Channel
     */
    public function getChannel(): Channel
    {
        return $this->channel;
    }

    /**
     * @return Bridge
     */
    public function getBridge(): Bridge
    {
        return $this->bridge;
    }
}
