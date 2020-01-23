<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Client\WebSocket\Ratchet;

use NgVoice\AriClient\Client\Rest\Resource\Applications;
use Ratchet\Client\Connector as RatchetConnector;
use React\EventLoop\LoopInterface;
use React\Socket\Connector as ReactConnector;

/**
 * A wrapper for optional ratchet web socket settings.
 *
 * @package NgVoice\AriClient\Client\WebSocket\Ratchet
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Settings
{
    private bool $subscribeAll = false;

    private ?Applications $ariApplicationsClient = null;

    private ?LoopInterface $loop = null;

    private ?ReactConnector $reactConnector = null;

    private ?RatchetConnector $ratchetConnector = null;

    /**
     * Check, if the Stasis application subscribes to all ARI events,
     * effectively disabling the application specific subscriptions.
     *
     * @return bool Flag, indicating if the this application should
     * subscribe to all Asterisk REST Interface events
     */
    public function isSubscribeAll(): bool
    {
        return $this->subscribeAll;
    }

    /**
     * Set the option to subscribe to all Asterisk REST Interface events,
     * effectively disabling the application specific subscriptions.
     *
     * @param $subscribeAll bool Flag, indicating if the this application should
     * subscribe to all Asterisk REST Interface events
     */
    public function setSubscribeAll(bool $subscribeAll): void
    {
        $this->subscribeAll = $subscribeAll;
    }

    /**
     * Get the ARI Applications REST client for event filtering on web socket connection.
     *
     * @return Applications|null The REST client
     */
    public function getAriApplicationsClient(): ?Applications
    {
        return $this->ariApplicationsClient;
    }

    /**
     * Set the ARI Applications REST client for event filtering on web socket connection.
     *
     * @param Applications $ariApplicationsClient The REST client
     */
    public function setAriApplicationsClient(Applications $ariApplicationsClient): void
    {
        $this->ariApplicationsClient = $ariApplicationsClient;
    }

    /**
     * @return LoopInterface|null
     */
    public function getLoop(): ?LoopInterface
    {
        return $this->loop;
    }

    /**
     * @param LoopInterface|null $loop The event loop
     * for this web socket client
     */
    public function setLoop(?LoopInterface $loop): void
    {
        $this->loop = $loop;
    }

    /**
     * @return ReactConnector|null
     */
    public function getReactConnector(): ?ReactConnector
    {
        return $this->reactConnector;
    }

    /**
     * @param ReactConnector|null $reactConnector @see \React\Socket\Connector
     */
    public function setReactConnector(?ReactConnector $reactConnector): void
    {
        $this->reactConnector = $reactConnector;
    }

    /**
     * @return RatchetConnector|null
     */
    public function getRatchetConnector(): ?RatchetConnector
    {
        return $this->ratchetConnector;
    }

    /**
     * @param RatchetConnector|null $ratchetConnector @see \Ratchet\Client\Connector
     */
    public function setRatchetConnector(?RatchetConnector $ratchetConnector): void
    {
        $this->ratchetConnector = $ratchetConnector;
    }
}
