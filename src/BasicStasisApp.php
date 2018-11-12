<?php

/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp;

use Monolog\Logger;
use AriStasisApp\ariclients\{AriWebSocketClient,
    BridgesClient,
    ChannelsClient,
    AsteriskClient,
    ApplicationsClient,
    DeviceStatesClient,
    EndpointsClient,
    EventsClient,
    MailboxesClient,
    PlaybacksClient,
    SoundsClient};

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
     * @var SoundsClient
     */
    protected $sounds;

    /**
     * @var EventsClient
     */
    protected $events;

    /**
     * @var BridgesClient
     */
    protected $bridges;

    /**
     * @var ChannelsClient
     */
    protected $channels;

    /**
     * @var AsteriskClient
     */
    protected $asterisk;

    /**
     * @var MailboxesClient
     */
    protected $mailboxes;

    /**
     * @var PlaybacksClient
     */
    protected $playbacks;

    /**
     * @var EndpointsClient
     */
    protected $endpoints;

    /**
     * @var ApplicationsClient
     */
    protected $applications;

    /**
     * @var DeviceStatesClient
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

        $this->sounds = new SoundsClient();
        $this->events = new EventsClient();
        $this->bridges = new BridgesClient();
        $this->channels = new ChannelsClient();
        $this->asterisk = new AsteriskClient();
        $this->mailboxes = new MailboxesClient();
        $this->endpoints = new EndpointsClient();
        $this->playbacks = new PlaybacksClient();
        $this->applications = new ApplicationsClient();
        $this->deviceStates = new DeviceStatesClient();
        $this->ariWebSocketClient = new AriWebSocketClient($stasisAppName);
    }

    /**
     * Run the application
     */
    function run()
    {
        $this->ariWebSocketClient->runWithEventHandlers();
        $this->handleEvents();
        $this->logger->info('Application is running and listening for events...');
    }

    /**
     * Stop the app by removing all the listeners and stop the WebSocketClient.
     */
    function stop()
    {
        $this->ariWebSocketClient->stop();
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
        $this->ariWebSocketClient->handle($eventName, $function);
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