<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Model\Message\Event;

use NgVoice\AriClient\Model\Channel;

/**
 * Notification that a channel has been destroyed.
 *
 * @package NgVoice\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ChannelDestroyed extends Event
{
    private int $cause;

    private string $causeTxt;

    private Channel $channel;

    /**
     * Integer representation of the cause of the hangup.
     *
     * @return int
     */
    public function getCause(): int
    {
        return $this->cause;
    }

    /**
     * Text representation of the cause of the hangup.
     *
     * @return string
     */
    public function getCauseTxt(): string
    {
        return $this->causeTxt;
    }

    /**
     * @return Channel
     */
    public function getChannel(): Channel
    {
        return $this->channel;
    }
}
