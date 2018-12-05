<?php
/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models\messages;


use AriStasisApp\models\Channel;

/**
 * Channel changed location in the dialplan.
 *
 * @package AriStasisApp\models\messages
 */
class ChannelDialplan extends Event
{
    /**
     * @var string The data to be passed to the application.
     */
    private $dialplanAppData;

    /**
     * @var Channel The channel that changed dialplan location.
     */
    private $channel;

    /**
     * @var string The application about to be executed.
     */
    private $dialplanApp;

    /**
     * @return string
     */
    public function getDialplanAppData(): string
    {
        return $this->dialplanAppData;
    }

    /**
     * @param string $dialplanAppData
     */
    public function setDialplanAppData(string $dialplanAppData): void
    {
        $this->dialplanAppData = $dialplanAppData;
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

    /**
     * @return string
     */
    public function getDialplanApp(): string
    {
        return $this->dialplanApp;
    }

    /**
     * @param string $dialplanApp
     */
    public function setDialplanApp(string $dialplanApp): void
    {
        $this->dialplanApp = $dialplanApp;
    }
}