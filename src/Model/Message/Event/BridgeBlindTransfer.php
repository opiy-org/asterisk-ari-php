<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model\Message\Event;

use OpiyOrg\AriClient\Model\{Bridge, Channel};

/**
 * Notification that a blind transfer has occurred.
 *
 * @package OpiyOrg\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class BridgeBlindTransfer extends Event
{
    private ?Bridge $bridge = null;

    private ?Channel $replaceChannel = null;

    private bool $isExternal;

    private string $exten;

    private string $result;

    private string $context;

    private ?Channel $transferee = null;

    private Channel $channel;

    /**
     * The bridge being transferred.
     *
     * @return Bridge|null
     */
    public function getBridge(): ?Bridge
    {
        return $this->bridge;
    }

    /**
     * The channel that is replacing transferer when
     * the transferee(s) can not be transferred directly.
     *
     * @return Channel|null
     */
    public function getReplaceChannel(): ?Channel
    {
        return $this->replaceChannel;
    }

    /**
     * Whether the transfer was externally initiated or not.
     *
     * @return bool
     */
    public function isExternal(): bool
    {
        return $this->isExternal;
    }

    /**
     * The extension transferred to.
     *
     * @return string
     */
    public function getExten(): string
    {
        return $this->exten;
    }

    /**
     * The result of the transfer attempt.
     *
     * @return string
     */
    public function getResult(): string
    {
        return $this->result;
    }

    /**
     * The context transferred to.
     *
     * @return string
     */
    public function getContext(): string
    {
        return $this->context;
    }

    /**
     * The channel that is being transferred.
     *
     * @return Channel|null
     */
    public function getTransferee(): ?Channel
    {
        return $this->transferee;
    }

    /**
     * The channel performing the blind transfer.
     *
     * @return Channel
     */
    public function getChannel(): Channel
    {
        return $this->channel;
    }
}
