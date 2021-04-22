<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model\Message\Event;

use OpiyOrg\AriClient\Model\Channel;

/**
 * Notification that a channel has been created.
 *
 * @package OpiyOrg\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ChannelCreated extends Event
{
    private Channel $channel;

    /**
     * The affected channel.
     *
     * @return Channel
     */
    public function getChannel(): Channel
    {
        return $this->channel;
    }
}
