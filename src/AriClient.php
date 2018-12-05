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

/**
 * The client instance to talk to the 'Asterisk RESTful Interface'.
 *
 * @package AriStasisApp
 */
class AriClient
{
    /**
     * @var Applications
     */
    private $applicationsClient;

    /**
     * @var Asterisk
     */
    private $asteriskClient;

    /**
     * @var Bridges
     */
    private $bridgesClient;

    /**
     * @var Channels
     */
    private $channelsClient;

    /**
     * @var DeviceStates
     */
    private $deviceStatesClient;

    /**
     * @var Endpoints
     */
    private $endpointsClient;

    /**
     * @var Events
     */
    private $eventsClient;

    /**
     * @var Mailboxes
     */
    private $mailboxesClient;

    /**
     * @var Playbacks
     */
    private $playbacksClient;

    /**
     * @var Recordings
     */
    private $recordingsClient;

    /**
     * @var Sounds
     */
    private $soundsClient;

    /**
     * AriClient constructor.
     *
     * @param string $ariUser
     * @param string $ariPassword
     * @param array $otherAriSettings
     */
    function __construct(string $ariUser, string $ariPassword, array $otherAriSettings = [])
    {
        $this->applicationsClient = new Applications($ariUser, $ariPassword, $otherAriSettings);
        $this->asteriskClient = new Asterisk($ariUser, $ariPassword, $otherAriSettings);
        $this->bridgesClient = new Bridges($ariUser, $ariPassword, $otherAriSettings);
        $this->channelsClient = new Channels($ariUser, $ariPassword, $otherAriSettings);
        $this->deviceStatesClient = new DeviceStates($ariUser, $ariPassword, $otherAriSettings);
        $this->endpointsClient = new Endpoints($ariUser, $ariPassword, $otherAriSettings);
        $this->eventsClient = new Events($ariUser, $ariPassword, $otherAriSettings);
        $this->mailboxesClient = new Mailboxes($ariUser, $ariPassword, $otherAriSettings);
        $this->playbacksClient = new Playbacks($ariUser, $ariPassword, $otherAriSettings);
        $this->recordingsClient = new Recordings($ariUser, $ariPassword, $otherAriSettings);
        $this->soundsClient = new Sounds($ariUser, $ariPassword, $otherAriSettings);
    }

    /**
     * @return Applications
     */
    public function getApplicationsClient(): Applications
    {
        return $this->applicationsClient;
    }

    /**
     * @return Asterisk
     */
    public function getAsteriskClient(): Asterisk
    {
        return $this->asteriskClient;
    }

    /**
     * @return Bridges
     */
    public function getBridgesClient(): Bridges
    {
        return $this->bridgesClient;
    }

    /**
     * @return Channels
     */
    public function getChannelsClient(): Channels
    {
        return $this->channelsClient;
    }

    /**
     * @return DeviceStates
     */
    public function getDeviceStatesClient(): DeviceStates
    {
        return $this->deviceStatesClient;
    }

    /**
     * @return Endpoints
     */
    public function getEndpointsClient(): Endpoints
    {
        return $this->endpointsClient;
    }

    /**
     * @return Events
     */
    public function getEventsClient(): Events
    {
        return $this->eventsClient;
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
     * @return Sounds
     */
    public function getSoundsClient(): Sounds
    {
        return $this->soundsClient;
    }
}