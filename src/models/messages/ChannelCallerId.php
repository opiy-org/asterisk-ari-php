<?php
/**
 * @author Lukas Stermann
 * @author Rick Barenthin
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
    private $callerPresentationText;

    /**
     * @var int The integer representation of the Caller Presentation value.
     */
    private $callerPresentation;

    /**
     * @var Channel The channel that changed Caller ID.
     */
    private $channel;

    /**
     * @return string
     */
    public function getCallerPresentationText(): string
    {
        return $this->callerPresentationText;
    }

    /**
     * @param string $callerPresentationText
     */
    public function setCallerPresentationText(string $callerPresentationText): void
    {
        $this->callerPresentationText = $callerPresentationText;
    }

    /**
     * @return int
     */
    public function getCallerPresentation(): int
    {
        return $this->callerPresentation;
    }

    /**
     * @param int $callerPresentation
     */
    public function setCallerPresentation(int $callerPresentation): void
    {
        $this->callerPresentation = $callerPresentation;
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