<?php

/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp;

use Monolog\Logger;
use AriStasisApp\rest_clients\{
    BridgesRestClient,
    ChannelsRestClient,
    AsteriskRestClient,
    ApplicationsRestClient,
    DeviceStatesRestClient,
    EndpointsRestClient,
    EventsRestClient,
    MailboxesRestClient,
    PlaybacksRestClient,
    RecordingsRestClient,
    SoundsRestClient};

require_once 'helping_functions.php';


/**
 * Class AriManager
 *
 * Represents a manager for the Asterisk RESTful Interface.
 * Beware that the default asterisk values will be used for your application.
 *
 * @package AriStasisApp
 */
class AriManager
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var SoundsRestClient
     */
    private $sounds;

    /**
     * @var EventsRestClient
     */
    private $events;

    /**
     * @var BridgesRestClient
     */
    private $bridges;

    /**
     * @var ChannelsRestClient
     */
    private $channels;

    /**
     * @var AsteriskRestClient
     */
    private $asterisk;

    /**
     * @var MailboxesRestClient
     */
    private $mailboxes;

    /**
     * @var PlaybacksRestClient
     */
    private $playbacks;

    /**
     * @var EndpointsRestClient
     */
    private $endpoints;

    /**
     * @var RecordingsRestClient
     */
    private $recordings;

    /**
     * @var ApplicationsRestClient
     */
    private $applications;

    /**
     * @var DeviceStatesRestClient
     */
    private $deviceStates;

    /**
     * AriManager constructor.
     *
     * @param bool $https_enabled
     * @param string $host
     * @param int $port
     * @param string $rootUrl
     * @param string $user
     * @param string $password
     */
    function __construct(bool $https_enabled = false,
                         string $host = '127.0.0.1',
                         int $port = 8088,
                         string $rootUrl = '/ari',
                         string $user = 'asterisk',
                         string $password = 'asterisk')
    {
        $this->logger = initLogger(getShortClassName($this));

        // Initialize all the asterisk REST Clients so we can easily send commands.
        $this->sounds = new SoundsRestClient($https_enabled, $host, $port, $rootUrl, $user, $password);
        $this->events = new EventsRestClient($https_enabled, $host, $port, $rootUrl, $user, $password);
        $this->bridges = new BridgesRestClient($https_enabled, $host, $port, $rootUrl, $user, $password);
        $this->channels = new ChannelsRestClient($https_enabled, $host, $port, $rootUrl, $user, $password);
        $this->asterisk = new AsteriskRestClient($https_enabled, $host, $port, $rootUrl, $user, $password);
        $this->mailboxes = new MailboxesRestClient($https_enabled, $host, $port, $rootUrl, $user, $password);
        $this->endpoints = new EndpointsRestClient($https_enabled, $host, $port, $rootUrl, $user, $password);
        $this->playbacks = new PlaybacksRestClient($https_enabled, $host, $port, $rootUrl, $user, $password);
        $this->recordings = new RecordingsRestClient($https_enabled, $host, $port, $rootUrl, $user, $password);
        $this->applications = new ApplicationsRestClient($https_enabled, $host, $port, $rootUrl, $user, $password);
        $this->deviceStates = new DeviceStatesRestClient($https_enabled, $host, $port, $rootUrl, $user, $password);
    }

    /**
     * @return Logger
     */
    function logger()
    {
        return $this->logger;
    }

    /**
     * @return SoundsRestClient
     */
    function sounds()
    {
        return $this->sounds;
    }

    /**
     * @return EventsRestClient
     */
    function events()
    {
        return $this->events;
    }

    /**
     * @return BridgesRestClient
     */
    function bridges()
    {
        return $this->bridges;
    }

    /**
     * @return ChannelsRestClient
     */
    function channels()
    {
        return $this->channels;
    }

    /**
     * @return AsteriskRestClient
     */
    function asterisk()
    {
        return $this->asterisk;
    }

    /**
     * @return MailboxesRestClient
     */
    function mailboxes()
    {
        return $this->mailboxes;
    }

    /**
     * @return EndpointsRestClient
     */
    function endpoints()
    {
        return $this->endpoints;
    }

    /**
     * @return PlaybacksRestClient
     */
    function playbacks()
    {
        return $this->playbacks;
    }

    /**
     * @return RecordingsRestClient
     */
    function recordings()
    {
        return $this->recordings;
    }

    /**
     * @return ApplicationsRestClient
     */
    function applications()
    {
        return $this->applications;
    }

    /**
     * @return DeviceStatesRestClient
     */
    function deviceStates()
    {
        return $this->deviceStates;
    }
}