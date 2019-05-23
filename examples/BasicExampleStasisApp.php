<?php

/**
 * @copyright 2019 ng-voice GmbH
 */

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Monolog\Logger;
use NgVoice\AriClient\AsteriskStasisApplication;
use NgVoice\AriClient\Models\Message\ChannelHangupRequest;
use NgVoice\AriClient\RestClient\{Asterisk as AriAsteriskClient,
    Events as AriEventsClient};

/**
 * Class BasicExampleStasisApp is an example for a base class to inject necessary
 * dependencies for your Stasis application.
 *
 * It is a good idea to design a base class for your stasis applications. Here you can
 * inject what you don't want to import into each of your application classes.
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
abstract class BasicExampleStasisApp implements AsteriskStasisApplication
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var AriEventsClient
     */
    protected $ariEventsClient;

    /**
     * @var AriAsteriskClient
     */
    protected $ariAsteriskClient;

    /**
     * BasicExampleStasisApp constructor.
     *
     * @param AriEventsClient $ariEventsClient
     * @param AriAsteriskClient $ariAsteriskClient
     * @param Logger $logger
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
     * A default message handler for channels that have been hung up.
     * Very helpful to avoid messy and/or duplicated code in your stasis application
     * classes!
     *
     * @param ChannelHangupRequest $channelHangupRequest
     */
    public function channelHangupRequest(ChannelHangupRequest $channelHangupRequest): void
    {
        $this->logger->info(
            'This is the default hangup handler in your parent class '
            . 'triggered by channel '
            . "'{$channelHangupRequest->getChannel()->getId()}' :-)"
        );
    }
}
