<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Monolog\Logger;
use NgVoice\AriClient\AsteriskStasisApplication;
use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use NgVoice\AriClient\RestClient\{
    Asterisk as AriAsteriskClient,
    Events as AriEventsClient};
use NgVoice\AriClient\Models\Message\{StasisStart, ChannelUserevent,
                                        ChannelHangupRequest, StasisEnd};

/**
 * Example for usage of this library in a local application.
 *
 * READ FIRST!
 * =======================================================================================
 * Open a terminal and start the example WebSocketClient worker script to receive
 * Asterisk events:
 * 'php example_app_worker.php'
 *
 * Define public functions in your app class, named after the Message you want to handle
 * (lowerCamelCase!). e.g. function someMessage(SomeMessage $someMessage){...} Other
 * Asterisk Messages received by the WebSocketClient will be ignored.
 *
 * For a list of all supported Messages, have a look at the /src/Models/Message
 * folder in this library. Alternatively you can    look them up in the official Asterisk
 * documentation:
 *
 * @see https://wiki.asterisk.org/wiki/display/AST/Asterisk+16+REST+Data+Models#Asterisk16RESTDataModels-Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 * @author Ahmad Hussain <ahmad@ng-voice.com>
 * =======================================================================================
 */
final class ExampleApp implements AsteriskStasisApplication
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var AriEventsClient
     */
    private $ariEventsClient;

    /**
     * @var AriAsteriskClient
     */
    private $ariAsteriskClient;

    /**
     * ExampleApp constructor.
     *
     * @param AriEventsClient $ariEventsClient REST client for
     * the 'Event' resource of the Asterisk REST Interface
     * @param AriAsteriskClient $ariAsteriskClient REST client
     * for the 'Asterisk' resource of the Asterisk REST Interface
     * @param Logger $logger Logger for debugging and information
     * about the states of the example app
     */
    public function __construct(
        AriEventsClient $ariEventsClient,
        AriAsteriskClient $ariAsteriskClient,
        Logger $logger
    ) {
        $this->ariEventsClient = $ariEventsClient;
        $this->ariAsteriskClient = $ariAsteriskClient;
        $this->logger = $logger;
    }

    /**
     * 'StasisStart' is the first event that is triggered by Asterisk
     * when a channel enters your Stasis application.
     *
     * @param StasisStart $stasisStart The Asterisk StasisStart event
     */
    public function stasisStart(StasisStart $stasisStart): void
    {
        $channelId = $stasisStart->getChannel()->getId();
        $this->logger->info("The channel {$channelId} has entered the ExampleApp.");

        /*
         * Asterisk provides the possibility to trigger user events
         * for specific applications. Perfect to test your setup :)
         */
        $userEventName = 'customEventExample';

        try {
            $this->ariEventsClient->userEvent(
                $userEventName,
                'ExampleApp',
                ['channel' => $channelId]
            );
        } catch (AsteriskRestInterfaceException $asteriskRestInterfaceException) {
            // Handle 4XX/5XX HTTP status codes. They will throw exceptions!
            $this->logger->error($asteriskRestInterfaceException->getMessage());
        }

        $this->logger->info("{$userEventName} event triggered in Asterisk.");
    }

    /**
     * User-generated event with additional user-defined fields in the object.
     * We will handle our user event we triggered after we received the StasisStart event.
     *
     * @param ChannelUserevent $channelUserevent The Asterisk ChannelUserevent event
     */
    public function channelUserevent(ChannelUserevent $channelUserevent): void
    {
        $this->logger->info(
            "ChannelUserevent received: {$channelUserevent->getEventname()}"
        );
        $this->logger->info(
            "Timestamp of the event: {$channelUserevent->getTimestamp()}"
        );

        /*
         * How about fetching your asterisk settings and
         * receiving the returning AsteriskInfo object?
         */
        try {
            $asteriskInfo = $this->ariAsteriskClient->getInfo();
            $this->logger->info($asteriskInfo->getBuild()->getOs());
        } catch (AsteriskRestInterfaceException $asteriskRestInterfaceException) {
            // Handle 4XX/5XX HTTP status codes. They will throw exceptions!
            $this->logger->error($asteriskRestInterfaceException->getMessage());
        }
    }

    /**
     * A default message handler for channels that have been hung up.
     *
     * @param ChannelHangupRequest $channelHangupRequest The Asterisk event
     */
    public function channelHangupRequest(ChannelHangupRequest $channelHangupRequest): void
    {
        $this->logger->info(
            'This is the default hangup handler triggered by channel '
            . "'{$channelHangupRequest->getChannel()->getId()}' :-)"
        );
    }

    /**
     * Notification that a channel has left your Stasis application.
     * Do some clean ups in your database here for example.
     *
     * @param StasisEnd $stasisEnd The Asterisk StasisEnd event
     */
    public function stasisEnd(StasisEnd $stasisEnd): void
    {
        $this->logger->info(
            "The channel {$stasisEnd->getChannel()->getId()} has left your example app."
        );
    }
}
