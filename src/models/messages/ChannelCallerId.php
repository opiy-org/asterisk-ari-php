<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models\messages;


use AriStasisApp\models\Channel;

/**
 * Channel changed Caller ID.
 *
 * @package AriStasisApp\models\messages
 */
class ChannelCallerId extends Event
{
    /**
     * @var string The text representation of the Caller Presentation value.
     */
    private $caller_presentation_text;

    /**
     * @var int The integer representation of the Caller Presentation value.
     */
    private $caller_presentation;

    /**
     * @var Channel The channel that changed Caller ID.
     */
    private $channel;

    /**
     * @return string
     */
    public function getCallerPresentationText(): string
    {
        return $this->caller_presentation_text;
    }

    /**
     * @param string $caller_presentation_text
     */
    public function setCallerPresentationText(string $caller_presentation_text): void
    {
        $this->caller_presentation_text = $caller_presentation_text;
    }

    /**
     * @return int
     */
    public function getCallerPresentation(): int
    {
        return $this->caller_presentation;
    }

    /**
     * @param int $caller_presentation
     */
    public function setCallerPresentation(int $caller_presentation): void
    {
        $this->caller_presentation = $caller_presentation;
    }

    /**
     * @return Channel
     */
    public function getChannel(): Channel
    {
        return $this->channel;
    }

    /**
     * @param Channel $channel
     */
    public function setChannel(Channel $channel): void
    {
        $this->channel = $channel;
    }
}