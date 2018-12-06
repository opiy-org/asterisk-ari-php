<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models\messages;


/**
 * Base type for errors and events.
 *
 * @package AriStasisApp\models\messages
 */
class Message
{
    /**
     * @var string Indicates the type of this message.
     */
    private $type;

    /**
     * @var string The unique ID for the Asterisk instance that raised this event.
     */
    private $asteriskId;

    /**
     * @return string
     */
    protected function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    protected function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    protected function getAsteriskId(): string
    {
        return $this->asteriskId;
    }

    /**
     * @param string $asteriskId
     */
    protected function setAsteriskId(string $asteriskId): void
    {
        $this->asteriskId = $asteriskId;
    }

}