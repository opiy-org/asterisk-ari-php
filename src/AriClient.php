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
     * @var Events
     */
    private $eventsClient;

    /**
     * @var Sounds
     */
    private $soundsClient;

    /**
     * @var Bridges
     */
    private $bridgesClient;

    /**
     * @var Asterisk
     */
    private $asteriskClient;

    /**
     * @var Channels
     */
    private $channelsClient;

    /**
     * @var Endpoints
     */
    private $endpointsClient;

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
     * @var Applications
     */
    private $applicationsClient;

    /**
     * @var DeviceStates
     */
    private $deviceStatesClient;

    /**
     * AriClient constructor.
     *
     * @param string $ariUser
     * @param string $ariPassword
     * @param array $otherAriSettings
     */
    function __construct(string $ariUser, string $ariPassword, array $otherAriSettings = [])
    {
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
}