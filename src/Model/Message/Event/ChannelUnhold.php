<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model\Message\Event;

use OpiyOrg\AriClient\Model\Channel;

/**
 * A channel initiated a media unhold.
 *
 * @package OpiyOrg\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ChannelUnhold extends Event
{
    private Channel $channel;

    /**
     * The channel that initiated the unhold event.
     *
     * @return Channel
     */
    public function getChannel(): Channel
    {
        return $this->channel;
    }
}
