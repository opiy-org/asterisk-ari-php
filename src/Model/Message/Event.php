<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\Model\Message;


/**
 * Base type for asynchronous events from Asterisk.
 *
 * @package AriStasisApp\Model\Message
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
    function getApplication(): string
    {
        return $this->application;
    }

    /**
     * @param string $application
     */
    function setApplication(string $application): void
    {
        $this->application = $application;
    }

    /**
     * @return string
     */
    function getTimestamp(): string
    {
        return $this->timestamp;
    }

    /**
     * @param string $timestamp
     */
    function setTimestamp(string $timestamp): void
    {
        $this->timestamp = $timestamp;
    }
}