<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\Model\Message;


/**
 * Base type for asynchronous events from Asterisk.
 *
 * @package NgVoice\AriClient\Model\Message
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