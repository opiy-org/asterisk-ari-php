<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model\Message\Event;

use OpiyOrg\AriClient\Model\Channel;

/**
 * Channel variable changed.
 *
 * @package OpiyOrg\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class ChannelVarset extends Event
{
    public string $variable;

    public ?Channel $channel = null;

    public string $value;

    /**
     * The variable that changed.
     *
     * @return string
     */
    public function getVariable(): string
    {
        return $this->variable;
    }

    /**
     * The channel on which the variable was set.
     *
     * If missing, the variable is a global variable.
     *
     * @return Channel|null
     */
    public function getChannel(): ?Channel
    {
        return $this->channel;
    }

    /**
     * The new value of the variable.
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
