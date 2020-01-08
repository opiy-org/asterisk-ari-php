<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Client\WebSocket\Ratchet;

use Monolog\Logger;
use NgVoice\AriClient\Client\Rest\Resource\Applications;
use Oktavlachs\DataMappingService\DataMappingService;
use Ratchet\Client\Connector as RatchetConnector;
use React\EventLoop\LoopInterface;
use React\Socket\Connector as ReactConnector;

/**
 * A wrapper for optional ratchet web socket settings.
 *
 * @package NgVoice\AriClient\WebSocket\Ratchet
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class OptionalSettings
{
    /**
     * If provided, a Stasis application will be subscribed to all ARI events,
     * effectively disabling the application specific subscriptions. Default is 'false'.
     */
    private bool $subscribeAll = false;

    /**
     * The client for the applications resource in Asterisk.
     *
     * This is used for event filtering on connection with the
     * web socket server.
     */
    private ?Applications $ariApplicationsClient = null;

    private ?LoopInterface $loop = null;

    private ?ReactConnector $reactConnector = null;

    private ?RatchetConnector $ratchetConnector = null;

    private ?Logger $logger = null;

    private ?DataMappingService $dataMappingService = null;

    /**
     * @return bool
     */
    public function isSubscribeAll(): bool
    {
        return $this->subscribeAll;
    }

    /**
     * @param bool $subscribeAll @see property $subscribeAll
     */
    public function setSubscribeAll(bool $subscribeAll): void
    {
        $this->subscribeAll = $subscribeAll;
    }

    /**
     * @return Applications|null
     */
    public function getAriApplicationsClient(): ?Applications
    {
        return $this->ariApplicationsClient;
    }

    /**
     * @param Applications $ariApplicationsClient @see property $ariApplicationsClient
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
     * @param LoopInterface|null $loop The event loop for this
     * web socket client
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

    /**
     * @return Logger|null
     */
    public function getLogger(): ?Logger
    {
        return $this->logger;
    }

    /**
     * @param Logger|null $logger The logger for this client
     */
    public function setLogger(?Logger $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * @return DataMappingService|null
     */
    public function getDataMappingService(): ?DataMappingService
    {
        return $this->dataMappingService;
    }

    /**
     * @param DataMappingService $dataMappingService Mapper for JSONs on objects
     */
    public function setDataMappingService(DataMappingService $dataMappingService): void
    {
        $this->dataMappingService = $dataMappingService;
    }
}
