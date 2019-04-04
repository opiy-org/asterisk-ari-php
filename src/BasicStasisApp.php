<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient;


use Monolog\Logger;
use NgVoice\AriClient\RestClient\{Applications,
    AriRestClientSettings,
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
     * @param AriRestClientSettings $ariRestClientSettings
     */
    public function __construct(AriRestClientSettings $ariRestClientSettings)
    {
        $this->logger = initLogger(getShortClassName($this));
        $this->eventsClient = new Events($ariRestClientSettings);
        $this->soundsClient = new Sounds($ariRestClientSettings);
        $this->bridgesClient = new Bridges($ariRestClientSettings);
        $this->asteriskClient = new Asterisk($ariRestClientSettings);
        $this->channelsClient = new Channels($ariRestClientSettings);
        $this->endpointsClient = new Endpoints($ariRestClientSettings);
        $this->mailboxesClient = new Mailboxes($ariRestClientSettings);
        $this->playbacksClient = new Playbacks($ariRestClientSettings);
        $this->recordingsClient = new Recordings($ariRestClientSettings);
        $this->applicationsClient = new Applications($ariRestClientSettings);
        $this->deviceStatesClient = new DeviceStates($ariRestClientSettings);
    }
}