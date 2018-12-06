<?php

/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models\messages;


/**
 * Base type for asynchronous events from Asterisk.
 *
 * @package AriStasisApp\models\messages
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
    protected function getApplication(): string
    {
        return $this->application;
    }

    /**
     * @param string $application
     */
    protected function setApplication(string $application): void
    {
        $this->application = $application;
    }

    /**
     * @return string
     */
    protected function getTimestamp(): string
    {
        return $this->timestamp;
    }

    /**
     * @param string $timestamp
     */
    protected function setTimestamp(string $timestamp): void
    {
        $this->timestamp = $timestamp;
    }
}