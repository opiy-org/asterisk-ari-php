<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

use AriStasisApp\BasicStasisApp;
use AriStasisApp\models\messages\{ChannelUserevent, StasisEnd, StasisStart};
use GuzzleHttp\Exception\GuzzleException;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Example for usage of this library in a local application.
 *
 * TODO: READ FIRST! ============================================================================
 * Open a terminal and start the example WebSocketClient worker script to receive Asterisk events.
 * 'php example_worker_local_app.php'
 *
 * Define public functions in your app class, named after the events you want to handle (lowerCamelCase!).
 * e.g. function someEvent(SomeEvent $someEvent){...}
 * Other events received by the WebSocketClient will be ignored.
 *
 * For a list of all available events, have a look at the /src/models/messages
 * folder in this library. Alternatively you can look them up in the official Asterisk documentation:
 * https://wiki.asterisk.org/wiki/display/AST/Asterisk+16+REST+Data+Models#Asterisk16RESTDataModels-Event
 * ==============================================================================================
 */
class ExampleLocalApp extends BasicStasisApp
{
    /**
     * 'StasisStart' is the first event that is triggered by Asterisk
     * when a channel enters your Stasis application.
     *
     * @param StasisStart $stasisStart
     */
    function stasisStart(StasisStart $stasisStart): void
    {
        $channelId = $stasisStart->getChannel()->getId();
        $this->logger->info("The channel {$channelId} has entered the ExampleLocalApp.");

        /*
         * Asterisk provides the possibility to trigger user events for specific applications.
         * Nice and simple to test your setup :)
         */
        $userEventName = 'customEventExample';

        try {
            $this->eventsClient->userEvent($userEventName, 'ExampleLocalApp', ['channel' => $channelId]);
        } catch (GuzzleException $guzzleException) {
            // Handle 4XX/5XX HTTP status codes. They will throw exceptions!
            $this->logger->error($guzzleException->getMessage());
        }

        $this->logger->info("{$userEventName} event triggered in Asterisk.");
    }

    /**
     * User-generated event with additional user-defined fields in the object.
     * We will handle our user event we triggered after we received the StasisStart event.
     *
     * @param ChannelUserevent $channelUserevent
     */
    function channelUserevent(ChannelUserevent $channelUserevent): void
    {
        $this->logger->info("ChannelUserevent received: {$channelUserevent->getEventname()}");
        $this->logger->info("Timestamp of the event: {$channelUserevent->getTimestamp()}");

        // How about fetching your asterisk settings and receiving the returning AsteriskInfo object?
        try {
            $asteriskInfo = $this->asteriskClient->getInfo();
            $this->logger->info($asteriskInfo->getBuild()->getOs());
        } catch (GuzzleException $guzzleException) {
            // Handle 4XX/5XX HTTP status codes. They will throw exceptions!
            $this->logger->error($guzzleException->getMessage());
        }
    }

    /**
     * Notification that a channel has left your Stasis application.
     * Do some clean ups in your database here for example.
     *
     * @param StasisEnd $stasisEnd
     */
    function stasisEnd(StasisEnd $stasisEnd): void
    {
        $this->logger->info("The channel {$stasisEnd->getChannel()->getId()} has left your example app.");
    }
}