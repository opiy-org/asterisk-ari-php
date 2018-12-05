<?php
/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models\messages;


use AriStasisApp\models\Channel;

/**
 * Notification that a channel has been destroyed.
 *
 * @package AriStasisApp\models\messages
 */
class ChannelDestroyed extends Event
{
    /**
     * @var int Integer representation of the cause of the hangup.
     */
    private $cause;

    /**
     * @var string Text representation of the cause of the hangup.
     */
    private $causeTxt;

    /**
     * @var Channel
     */
    private $channel;

    /**
     * @return int
     */
    public function getCause(): int
    {
        return $this->cause;
    }

    /**
     * @param int $cause
     */
    public function setCause(int $cause): void
    {
        $this->cause = $cause;
    }

    /**
     * @return string
     */
    public function getCauseTxt(): string
    {
        return $this->causeTxt;
    }

    /**
     * @param string $causeTxt
     */
    public function setCauseTxt(string $causeTxt): void
    {
        $this->causeTxt = $causeTxt;
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