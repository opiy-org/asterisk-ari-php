<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model\Message\Event;

use OpiyOrg\AriClient\Model\Channel;

/**
 * Notification that a channel has entered a Stasis application.
 *
 * @package OpiyOrg\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class StasisStart extends Event
{
    /**
     * @var array<int, string> Arguments to the application.
     */
    public array $args = [];

    public ?Channel $replaceChannel = null;

    public Channel $channel;

    /**
     * @return array<int, string>
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * @return Channel|null
     */
    public function getReplaceChannel(): ?Channel
    {
        return $this->replaceChannel;
    }

    /**
     * @return Channel
     */
    public function getChannel(): Channel
    {
        return $this->channel;
    }
}
