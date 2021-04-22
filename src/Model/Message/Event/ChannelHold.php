<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model\Message\Event;

use OpiyOrg\AriClient\Model\Channel;

/**
 * A channel initiated a media hold.
 *
 * @package OpiyOrg\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ChannelHold extends Event
{
    private ?string $musicclass = null;

    private Channel $channel;

    /**
     * The music on hold class that the initiator requested.
     *
     * @return string|null
     */
    public function getMusicclass(): ?string
    {
        return $this->musicclass;
    }

    /**
     * The channel that initiated the hold event.
     *
     * @return Channel
     */
    public function getChannel(): Channel
    {
        return $this->channel;
    }
}
