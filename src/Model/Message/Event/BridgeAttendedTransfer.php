<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model\Message\Event;

use OpiyOrg\AriClient\Model\{Bridge, Channel};

/**
 * Notification that an attended transfer has occurred.
 *
 * @package OpiyOrg\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class BridgeAttendedTransfer extends Event
{
    private ?string $destinationApplication = null;

    private ?string $destinationBridge = null;

    private ?Channel $destinationLinkFirstLeg = null;

    private ?Channel $destinationLinkSecondLeg = null;

    private ?Bridge $destinationThreewayBridge = null;

    private ?Channel $destinationThreewayChannel = null;

    private string $destinationType;

    private bool $isExternal;

    private ?Channel $replaceChannel = null;

    private string $result;

    private ?Channel $transferTarget = null;

    private ?Channel $transferee = null;

    private Channel $transfererFirstLeg;

    private ?Bridge $transfererFirstLegBridge = null;

    private Channel $transfererSecondLeg;

    private ?Bridge $transfererSecondLegBridge = null;

    /**
     * Application that has been transferred into.
     *
     * @return string|null
     */
    public function getDestinationApplication(): ?string
    {
        return $this->destinationApplication;
    }

    /**
     * Bridge that survived the merge result.
     *
     * @return string|null
     */
    public function getDestinationBridge(): ?string
    {
        return $this->destinationBridge;
    }

    /**
     * First leg of a link transfer result.
     *
     * @return Channel|null
     */
    public function getDestinationLinkFirstLeg(): ?Channel
    {
        return $this->destinationLinkFirstLeg;
    }

    /**
     * Second leg of a link transfer result.
     *
     * @return Channel|null
     */
    public function getDestinationLinkSecondLeg(): ?Channel
    {
        return $this->destinationLinkSecondLeg;
    }

    /**
     * Bridge that survived the threeway result.
     *
     * @return Bridge|null
     */
    public function getDestinationThreewayBridge(): ?Bridge
    {
        return $this->destinationThreewayBridge;
    }

    /**
     * Transferer channel that survived the threeway result.
     *
     * @return Channel|null
     */
    public function getDestinationThreewayChannel(): ?Channel
    {
        return $this->destinationThreewayChannel;
    }

    /**
     * How the transfer was accomplished.
     *
     * @return string
     */
    public function getDestinationType(): string
    {
        return $this->destinationType;
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
     * The channel that is replacing transferer_first_leg in the swap.
     *
     * @return Channel|null
     */
    public function getReplaceChannel(): ?Channel
    {
        return $this->replaceChannel;
    }

    /**
     * The result of the transfer attempt
     *
     * @return string
     */
    public function getResult(): string
    {
        return $this->result;
    }

    /**
     * The channel that is being transferred to.
     *
     * @return Channel|null
     */
    public function getTransferTarget(): ?Channel
    {
        return $this->transferTarget;
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
     * First leg of the transferer.
     *
     * @return Channel
     */
    public function getTransfererFirstLeg(): Channel
    {
        return $this->transfererFirstLeg;
    }

    /**
     * Bridge the transferer first leg is in.
     *
     * @return Bridge|null
     */
    public function getTransfererFirstLegBridge(): ?Bridge
    {
        return $this->transfererFirstLegBridge;
    }

    /**
     * Second leg of the transferer.
     *
     * @return Channel
     */
    public function getTransfererSecondLeg(): Channel
    {
        return $this->transfererSecondLeg;
    }

    /**
     * Bridge the transferer second leg is in.
     *
     * @return Bridge|null
     */
    public function getTransfererSecondLegBridge(): ?Bridge
    {
        return $this->transfererSecondLegBridge;
    }
}
