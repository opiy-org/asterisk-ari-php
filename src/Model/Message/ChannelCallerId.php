<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\Model\Message;


use NgVoice\AriClient\Model\Channel;

/**
 * Channel changed Caller ID.
 *
 * @package NgVoice\AriClient\Model\Message
 */
class ChannelCallerId extends Event
{
    /**
     * @var string The text representation of the Caller Presentation value.
     */
    private $caller_presentation_txt;

    /**
     * @var int The integer representation of the Caller Presentation value.
     */
    private $caller_presentation;

    /**
     * @var \NgVoice\AriClient\Model\Channel The channel that changed Caller ID.
     */
    private $channel;

    /**
     * @return string
     */
    public function getCallerPresentationTxt(): string
    {
        return $this->caller_presentation_txt;
    }

    /**
     * @param string $caller_presentation_txt
     */
    public function setCallerPresentationTxt(string $caller_presentation_txt): void
    {
        $this->caller_presentation_txt = $caller_presentation_txt;
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