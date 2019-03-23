<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient;


use Monolog\Logger;
use NgVoice\AriClient\RestClient\{Applications,
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
     * @return Logger
     */
    public function getLogger(): Logger
    {
        return $this->logger;
    }

    /**
     * @return Events
     */
    public function getEventsClient(): Events
    {
        return $this->eventsClient;
    }

    /**
     * @return Sounds
     */
    public function getSoundsClient(): Sounds
    {
        return $this->soundsClient;
    }

    /**
     * @return Bridges
     */
    public function getBridgesClient(): Bridges
    {
        return $this->bridgesClient;
    }

    /**
     * @return Asterisk
     */
    public function getAsteriskClient(): Asterisk
    {
        return $this->asteriskClient;
    }

    /**
     * @return Channels
     */
    public function getChannelsClient(): Channels
    {
        return $this->channelsClient;
    }

    /**
     * @return Endpoints
     */
    public function getEndpointsClient(): Endpoints
    {
        return $this->endpointsClient;
    }

    /**
     * @return Mailboxes
     */
    public function getMailboxesClient(): Mailboxes
    {
        return $this->mailboxesClient;
    }

    /**
     * @return Playbacks
     */
    public function getPlaybacksClient(): Playbacks
    {
        return $this->playbacksClient;
    }

    /**
     * @return Recordings
     */
    public function getRecordingsClient(): Recordings
    {
        return $this->recordingsClient;
    }

    /**
     * @return Applications
     */
    public function getApplicationsClient(): Applications
    {
        return $this->applicationsClient;
    }

    /**
     * @return DeviceStates
     */
    public function getDeviceStatesClient(): DeviceStates
    {
        return $this->deviceStatesClient;
    }

    /**
     * BasicStasisApp constructor.
     *
     * @param string $ariUser
     * @param string $ariPassword
     * @param array $otherAriSettings
     */
    public function __construct(string $ariUser, string $ariPassword, array $otherAriSettings = [])
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