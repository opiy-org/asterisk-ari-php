<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Client\WebSocket;

use React\EventLoop\LoopInterface;

/**
 * Define the basic features a web socket client implementation must offer.
 *
 * @package OpiyOrg\AriClient\Client\WebSocket
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
interface WebSocketClientInterface
{
    /**
     * Method prefix that implies that a method defined within an
     * StasisApplication class handles a certain ARI event.
     */
    public const ARI_EVENT_HANDLER_METHOD_PREFIX = 'onAriEvent';

    /**
     * Establish the connection to the WebSocket of your Asterisk instance
     * and listen for specific incoming events.
     */
    public function start(): void;

    /**
     * Get the event loop.
     *
     * @return LoopInterface
     */
    public function getLoop(): LoopInterface;
}
