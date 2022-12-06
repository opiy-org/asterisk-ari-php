<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model\Message\Event;

use OpiyOrg\AriClient\Model\Channel;

/**
 * Channel changed location in the dialplan.
 *
 * @package OpiyOrg\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class ChannelDialplan extends Event
{
    public string $dialplanAppData;

    public Channel $channel;

    public string $dialplanApp;

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
