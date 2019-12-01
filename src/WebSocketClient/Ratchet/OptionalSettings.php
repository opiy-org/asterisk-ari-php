<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\WebSocketClient\Ratchet;

use JsonMapper;
use Monolog\Logger;
use NgVoice\AriClient\RestClient\ResourceClient\Applications;
use Ratchet\Client\Connector as RatchetConnector;
use React\EventLoop\LoopInterface;
use React\Socket\Connector as ReactConnector;

/**
 * A wrapper for optional ratchet web socket settings.
 *
 * @package NgVoice\AriClient\WebSocketClient\Ratchet
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class OptionalSettings
{
    /**
     * @var bool
     */
    private $subscribeAll = false;

    /**
     * @var Applications|null
     */
    private $ariApplicationsClient;

    /**
     * @var LoopInterface|null
     */
    private $loop;

    /**
     * @var ReactConnector|null
     */
    private $reactConnector;

    /**
     * @var RatchetConnector|null
     */
    private $ratchetConnector;

    /**
     * @var Logger|null
     */
    private $logger;

    /**
     * @var JsonMapper|null
     */
    private $jsonMapper;

    /**
     * @return bool
     */
    public function isSubscribeAll(): bool
    {
        return $this->subscribeAll;
    }

    /**
     * @param bool $subscribeAll Subscribe to all Asterisk events.
     * If provided, the applications listed will be subscribed to all events,
     * effectively disabling the application specific subscriptions. Default is 'false'.
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
     * @param Applications $ariApplicationsClient ARI Applications REST client
     * for event filtering on web socket connection.
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
     * @return JsonMapper|null
     */
    public function getJsonMapper(): ?JsonMapper
    {
        return $this->jsonMapper;
    }

    /**
     * @param JsonMapper $jsonMapper Mapper for Jsons on objects
     */
    public function setJsonMapper(JsonMapper $jsonMapper): void
    {
        $this->jsonMapper = $jsonMapper;
    }
}
