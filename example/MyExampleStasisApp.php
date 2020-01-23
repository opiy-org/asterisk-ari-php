<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use NgVoice\AriClient\StasisApplicationInterface;
use NgVoice\AriClient\Client\Rest\Resource\Channels;
use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use NgVoice\AriClient\Model\Message\Event\{ChannelHangupRequest,
    ChannelUserevent,
    StasisEnd,
    StasisStart};

/**
 * Example for usage of this library in a local application.
 *
 * READ FIRST!
 * =======================================================================================
 * Open a terminal and start the example WebSocket worker script to receive
 * Asterisk events:
 * 'php my_example_stasis_app_worker.php'
 *
 * Define public functions in your app class, named after the Event you want to handle
 * (lowerCamelCase!). e.g. function someMessage(SomeMessage $someMessage){...} Other
 * Asterisk Messages received by the WebSocket will be ignored.
 *
 * For a list of all supported Messages, have a look at the /src/Model/Event
 * folder in this library. Alternatively you can    look them up in the official Asterisk
 * documentation:
 *
 * @see https://wiki.asterisk.org/wiki/display/AST/Asterisk+16+REST+Data+Models#Asterisk16RESTDataModels-Event
 * =======================================================================================
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class MyExampleStasisApp implements StasisApplicationInterface
{
    private Channels $ariChannelsClient;

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
    public function onAriEventStasisStart(StasisStart $stasisStart): void
    {
        $channelId = $stasisStart->getChannel()->getId();
        printf(
            "The channel '%s' has entered the MyExampleStasisApp.\n",
            $channelId
        );

        /*
         * Now we get the list of active channels available in
         * the Application through Asterisk Rest Interface.
         */
        foreach ($this->ariChannelsClient->list() as $activeChannel) {
            printf(
                "The channel id: '%s' and the channel name: '%s' "
                . "is active in the MyExampleStasisApp.\n",
                $activeChannel->getId(),
                $activeChannel->getName()
            );
        }
    }

    /**
     * A default event handler for channels that have been hung up.
     *
     * @param ChannelHangupRequest $channelHangupRequest The Asterisk event
     */
    public function onAriEventChannelHangupRequest(
        ChannelHangupRequest $channelHangupRequest
    ): void {
        printf(
            "This is the default hangup handler triggered by channel '%s' :-)\n",
            $channelHangupRequest->getChannel()->getId()
        );
    }

    /**
     * Notification that a channel has left your Stasis application.
     * Do some clean ups in your database here for example.
     *
     * @param StasisEnd $stasisEnd The Asterisk StasisEnd event
     */
    public function onAriEventStasisEnd(StasisEnd $stasisEnd): void
    {
        printf(
            "The channel '%s' has left your example app.\n",
            $stasisEnd->getChannel()->getId()
        );
    }

    /**
     * While every other event is triggered by Asterisk,
     * the ChannelUserevent can be triggered by yourself.
     *
     * When you execute the my_example_stasis_app_worker.php script,
     * this event will be triggered every few seconds.
     *
     * @param ChannelUserevent $channelUserevent The ChannelUserevent
     * which is triggered in my_example_stasis_app_worker.php
     *
     * @return void
     */
    public function onAriEventChannelUserevent(ChannelUserevent $channelUserevent): void
    {
        $errorMessage = sprintf(
            "This is the unhandled exception for ChannelUserEvent '%s' !",
            $channelUserevent->getEventname()
        );

        throw new InvalidArgumentException($errorMessage);
    }
}
