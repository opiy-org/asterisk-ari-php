<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model\Message\Event;

use OpiyOrg\AriClient\Model\Message\Message;

/**
 * Base type for asynchronous events from Asterisk.
 *
 * @package OpiyOrg\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class Event extends Message
{
    public string $application;

    public string $timestamp;

    /**
     * Name of the application receiving the event.
     *
     * @return string
     */
    public function getApplication(): string
    {
        return $this->application;
    }

    /**
     * Time at which this event was created.
     *
     * @return string
     */
    public function getTimestamp(): string
    {
        return $this->timestamp;
    }
}
