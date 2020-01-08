<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Model\Message\Event;

use NgVoice\AriClient\Model\Channel;

/**
 * Channel changed location in the dialplan.
 *
 * @package NgVoice\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ChannelDialplan extends Event
{
    private string $dialplanAppData;

    private Channel $channel;

    private string $dialplanApp;

    /**
     * The data to be passed to the application.
     *
     * @return string
     */
    public function getDialplanAppData(): string
    {
        return $this->dialplanAppData;
    }

    /**
     * The channel that changed dialplan location.
     *
     * @return Channel
     */
    public function getChannel(): Channel
    {
        return $this->channel;
    }

    /**
     * The application about to be executed.
     *
     * @return string
     */
    public function getDialplanApp(): string
    {
        return $this->dialplanApp;
    }
}
