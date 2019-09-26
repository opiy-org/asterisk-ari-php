<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use NgVoice\AriClient\AsteriskStasisApplication;
use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use NgVoice\AriClient\Models\Message\{ChannelHangupRequest, StasisEnd, StasisStart};
use NgVoice\AriClient\RestClient\Channels;

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
final class MyExampleStasisApp implements AsteriskStasisApplication
{
    /**
     * @var Channels
     */
    private $ariChannelsClient;

    /**
     * MyExampleStasisApp constructor.
     *
     * @param Channels $ariChannelsClient REST client for
     * the 'Channels' resource of the Asterisk REST Interface
     */
    public function __construct(Channels $ariChannelsClient)
    {
        $this->ariChannelsClient = $ariChannelsClient;
    }

    /**
     * 'StasisStart' is the first event that is triggered by Asterisk
     * when a channel enters your Stasis application.
     *
     * @param StasisStart $stasisStart The Asterisk StasisStart event
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function stasisStart(StasisStart $stasisStart): void
    {
        $channelId = $stasisStart->getChannel()->getId();
        echo "The channel {$channelId} has entered the MyExampleStasisApp.\n";

        /*
         * Now we get the list of active channels available in the Application
         * through Asterisk Rest Interface
         */
        foreach ($this->ariChannelsClient->list() as $activeChannel) {
            echo "The channel id: {$activeChannel->getId()} and the channel name: "
                . "{$activeChannel->getName()} is active in the MyExampleStasisApp.\n";
        }
    }

    /**
     * A default event handler for channels that have been hung up.
     *
     * @param ChannelHangupRequest $channelHangupRequest The Asterisk event
     */
    public function channelHangupRequest(ChannelHangupRequest $channelHangupRequest): void
    {
        echo 'This is the default hangup handler triggered by channel '
            . "'{$channelHangupRequest->getChannel()->getId()}' :-)\n";
    }

    /**
     * Notification that a channel has left your Stasis application.
     * Do some clean ups in your database here for example.
     *
     * @param StasisEnd $stasisEnd The Asterisk StasisEnd event
     */
    public function stasisEnd(StasisEnd $stasisEnd): void
    {
        echo "The channel {$stasisEnd->getChannel()->getId()} "
            . "has left your example app.\n";
    }
}
