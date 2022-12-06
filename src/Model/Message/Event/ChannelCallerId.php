<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model\Message\Event;

use OpiyOrg\AriClient\Model\Channel;

/**
 * Channel changed Caller ID.
 *
 * @package OpiyOrg\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class ChannelCallerId extends Event
{
    public string $callerPresentationTxt;

    public int $callerPresentation;

    public Channel $channel;

    /**
     * The text representation of the Caller Presentation value.
     *
     * @return string
     */
    public function getCallerPresentationTxt(): string
    {
        return $this->callerPresentationTxt;
    }

    /**
     * The integer representation of the Caller Presentation value.
     *
     * @return int
     */
    public function getCallerPresentation(): int
    {
        return $this->callerPresentation;
    }

    /**
     * The channel that changed Caller ID.
     *
     * @return Channel
     */
    public function getChannel(): Channel
    {
        return $this->channel;
    }
}
