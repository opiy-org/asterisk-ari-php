<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

use AriStasisApp\BasicStasisApp;
use AriStasisApp\models\messages\{ChannelUserevent, StasisStart};
use GuzzleHttp\Exception\GuzzleException;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Example for usage of this library in a local application.
 *
 * TODO: READ FIRST! ============================================================================
 * Open a terminal and start the example WebSocketClient worker script to receive Asterisk events.
 * 'php example_worker_local_app.php'
 *
 * Define functions named after the events you want to handle (lowerCamelCase!).
 * Other events will be ignored.
 *
 * For a list of all available events, have a look at the /src/models/messages
 * folder in this library. Alternatively look at the official Asterisk documentation.
 *
 * If you find any bugs, feel free to open an issue in the repository or send us an email :)
 * ==============================================================================================
 */
class ExampleLocalApp extends BasicStasisApp
{

    /**
     * 'StasisStart' is the first event that is triggered by Asterisk, when a call enters your application.
     *
     * @param StasisStart $stasisStart
     */
    function stasisStart(StasisStart $stasisStart): void
    {
        $this->logger->info($stasisStart->getChannel());

        /**
         * Asterisk provides the possibility to generate user events for specific applications.
         * Nice and simple to test your setup :)
         */
        try {
            $this->eventsClient->userEvent('customEventExample', 'ExampleLocalApp');
        } catch (GuzzleException $guzzleException) {
            // Handle 4XX/5XX HTTP status codes. They will throw exceptions!
            $this->logger->error($guzzleException->getMessage());
        }
    }

    /**
     * Now we will handle our user event that we sent via REST call before.
     *
     * @param ChannelUserevent $channelUserevent
     */
    function channelUserevent(ChannelUserevent $channelUserevent): void
    {
        $this->logger->info($channelUserevent->getEventname());

        // How about fetching your asterisk settings and receiving the returning AsteriskInfo object?
        try {
            $asteriskInfo = $this->asteriskClient->getInfo();
            $this->logger->info($asteriskInfo->getBuild());
        } catch (GuzzleException $guzzleException) {
            $this->logger->error($guzzleException->getMessage());
        }
    }
}