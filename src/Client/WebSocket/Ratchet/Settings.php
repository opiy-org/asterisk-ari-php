<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Client\WebSocket\Ratchet;

use Ratchet\Client\Connector as RatchetConnector;
use React\EventLoop\LoopInterface;
use React\Socket\Connector as ReactConnector;

/**
 * A wrapper for optional ratchet web socket settings.
 *
 * @package OpiyOrg\AriClient\Client\WebSocket\Ratchet
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class Settings
{
    private ?LoopInterface $loop = null;

    private ?ReactConnector $reactConnector = null;

    private ?RatchetConnector $ratchetConnector = null;

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
