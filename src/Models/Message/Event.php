<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Models\Message;


/**
 * Base type for asynchronous events from Asterisk.
 *
 * @package NgVoice\AriClient\Models\Message
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class Event extends Message
{
    /**
     * @var string Name of the application receiving the event.
     */
    private $application;

    /**
     * @var string Time at which this event was created.
     */
    private $timestamp;

    /**
     * @return string
     */
    public function getApplication(): string
    {
        return $this->application;
    }

    /**
     * @param string $application
     */
    public function setApplication(string $application): void
    {
        $this->application = $application;
    }

    /**
     * @return string
     */
    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    /**
     * @param string $timestamp
     */
    public function setTimestamp(string $timestamp): void
    {
        $this->timestamp = $timestamp;
    }
}
