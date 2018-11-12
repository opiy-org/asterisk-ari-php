<?php

/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp;

use Monolog\Logger;
use AriStasisApp\rest_clients\{AriWebSocketClient,
    BridgesRestClient,
    ChannelsRestClient,
    AsteriskRestClient,
    ApplicationsRestClient,
    DeviceStatesRestClient,
    EndpointsRestClient,
    EventsRestClient,
    MailboxesRestClient,
    PlaybacksRestClient,
    SoundsRestClient};

require_once 'helping_functions.php';


/**
 * Class BasicStasisApp
 *
 * Represents a basic asterisk stasis application. Your own stasis application has to extend this class and also
 * should implement the BasicStasisAppInterface.
 *
 */
abstract class BasicStasisApp
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var SoundsRestClient
     */
    protected $sounds;

    /**
     * @var EventsRestClient
     */
    protected $events;

    /**
     * @var BridgesRestClient
     */
    protected $bridges;

    /**
     * @var ChannelsRestClient
     */
    protected $channels;

    /**
     * @var AsteriskRestClient
     */
    protected $asterisk;

    /**
     * @var MailboxesRestClient
     */
    protected $mailboxes;

    /**
     * @var PlaybacksRestClient
     */
    protected $playbacks;

    /**
     * @var EndpointsRestClient
     */
    protected $endpoints;

    /**
     * @var ApplicationsRestClient
     */
    protected $applications;

    /**
     * @var DeviceStatesRestClient
     */
    protected $deviceStates;

    /**
     * @var AriWebSocketClient
     */
    private $ariWebSocketClient;

    /**
     * BasicStasisApp constructor.
     *
     */
    function __construct()
    {
        $stasisAppName = getShortClassName($this);
        $this->logger = initLogger($stasisAppName);

        $this->sounds = new SoundsRestClient();
        $this->events = new EventsRestClient();
        $this->bridges = new BridgesRestClient();
        $this->channels = new ChannelsRestClient();
        $this->asterisk = new AsteriskRestClient();
        $this->mailboxes = new MailboxesRestClient();
        $this->endpoints = new EndpointsRestClient();
        $this->playbacks = new PlaybacksRestClient();
        $this->applications = new ApplicationsRestClient();
        $this->deviceStates = new DeviceStatesRestClient();
        $this->ariWebSocketClient = new AriWebSocketClient($stasisAppName);
    }

    /**
     * Run the application
     */
    function run()
    {
        // TODO: Don't do that but refactor the possibility to write a local application?!
        // TODO: This is not working at the moment!!!!
        //$this->ariWebSocketClient->publishWithAMQP();
        //$this->handleEvents();
        $this->logger->info('Application is running and listening for events...');
    }

    /**
     * Stop the app by removing all the listeners and stop the WebSocketClient.
     */
    function stop()
    {
        //$this->ariWebSocketClient->stop();
        $this->logger->info("Application has stopped. Terminating...");
    }

    /**
     * Handle an event. A shorter version to avoid messy code in your own application class.
     *
     * @param string $eventName
     * @param callable $function
     */
    protected function handle(string $eventName, callable $function)
    {
        //$this->ariWebSocketClient->handle($eventName, $function);
    }

    /**
     *
     * Add your individual event listeners for your stasis application and handle them in here.
     * It's very easy as it follows this example pattern:
     *
     *      $this->handle('StasisEventName', function ($eventBody){
     *          // Do something.
     *      });
     *
     * Add as many listeners as you like. You can find all types of events in the asterisk documentation:
     * https://wiki.asterisk.org/wiki/display/AST/Asterisk+16+REST+Data+Models#Asterisk16RESTDataModels-Event
     */
    protected abstract function handleEvents();
}