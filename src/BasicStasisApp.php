<?php

/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp;


use AriStasisApp\rest_clients\{Applications,
    Asterisk,
    Bridges,
    Channels,
    DeviceStates,
    Endpoints,
    Events,
    Mailboxes,
    Playbacks,
    Recordings,
    Sounds};
use Monolog\Logger;

/**
 * A main client to talk to the 'Asterisk RESTful Interface'.
 *
 * @package AriStasisApp
 */
class BasicStasisApp
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var Events
     */
    protected $eventsClient;

    /**
     * @var Sounds
     */
    protected $soundsClient;

    /**
     * @var Bridges
     */
    protected $bridgesClient;

    /**
     * @var Asterisk
     */
    protected $asteriskClient;

    /**
     * @var Channels
     */
    protected $channelsClient;

    /**
     * @var Endpoints
     */
    protected $endpointsClient;

    /**
     * @var Mailboxes
     */
    protected $mailboxesClient;

    /**
     * @var Playbacks
     */
    protected $playbacksClient;

    /**
     * @var Recordings
     */
    protected $recordingsClient;

    /**
     * @var Applications
     */
    protected $applicationsClient;

    /**
     * @var DeviceStates
     */
    protected $deviceStatesClient;

    /**
     * BasicStasisApp constructor.
     *
     * @param string $ariUser
     * @param string $ariPassword
     * @param array $otherAriSettings
     */
    function __construct(string $ariUser, string $ariPassword, array $otherAriSettings = [])
    {
        $this->logger = initLogger(getShortClassName($this));
        $this->eventsClient = new Events($ariUser, $ariPassword, $otherAriSettings);
        $this->soundsClient = new Sounds($ariUser, $ariPassword, $otherAriSettings);
        $this->bridgesClient = new Bridges($ariUser, $ariPassword, $otherAriSettings);
        $this->asteriskClient = new Asterisk($ariUser, $ariPassword, $otherAriSettings);
        $this->channelsClient = new Channels($ariUser, $ariPassword, $otherAriSettings);
        $this->endpointsClient = new Endpoints($ariUser, $ariPassword, $otherAriSettings);
        $this->mailboxesClient = new Mailboxes($ariUser, $ariPassword, $otherAriSettings);
        $this->playbacksClient = new Playbacks($ariUser, $ariPassword, $otherAriSettings);
        $this->recordingsClient = new Recordings($ariUser, $ariPassword, $otherAriSettings);
        $this->applicationsClient = new Applications($ariUser, $ariPassword, $otherAriSettings);
        $this->deviceStatesClient = new DeviceStates($ariUser, $ariPassword, $otherAriSettings);
    }
}