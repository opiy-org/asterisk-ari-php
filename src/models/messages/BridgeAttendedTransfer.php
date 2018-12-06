<?php

/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models\messages;


use AriStasisApp\models\Bridge;
use AriStasisApp\models\Channel;

/**
 * Notification that an attended transfer has occurred.
 *
 * @package AriStasisApp\models\messages
 */
class BridgeAttendedTransfer extends Event
{
    /**
     * @var Channel The channel that is replacing transferer_first_leg in the swap.
     */
    private $replaceChannel;

    /**
     * @var boolean Whether the transfer was externally initiated or not.
     */
    private $isExternal;

    /**
     * @var Bridge Bridge the transferer second leg is in.
     */
    private $transfererSecondLegBridge;

    /**
     * @var string Bridge that survived the merge result.
     */
    private $destinationBridge;

    /**
     * @var Channel Second leg of the transferer.
     */
    private $transfererSecondLeg;

    /**
     * @var Channel Second leg of a link transfer result.
     */
    private $destinationLinkSecondLeg;

    /**
     * @var Channel Transferer channel that survived the threeway result.
     */
    private $destinationThreewayChannel;

    /**
     * @var Channel The channel that is being transferred to.
     */
    private $transferTarget;

    /**
     * @var string The result of the transfer attempt.
     */
    private $result;

    /**
     * @var string How the transfer was accomplished.
     */
    private $destinationType;

    /**
     * @var string Application that has been transferred into.
     */
    private $destinationApplication;

    /**
     * @var Bridge Bridge that survived the threeway result.
     */
    private $destinationThreewayBridge;

    /**
     * @var Channel First leg of a link transfer result.
     */
    private $destinationLinkFirstLeg;

    /**
     * @var Channel The channel that is being transferred.
     */
    private $transferee;

    /**
     * @var Channel First leg of the transferer.
     */
    private $transfererFirstLeg;

    /**
     * @var Bridge Bridge the transferer first leg is in.
     */
    private $transfererFirstLegBridge;

    /**
     * @return Channel
     */
    public function getReplaceChannel(): Channel
    {
        return $this->replaceChannel;
    }

    /**
     * @param Channel $replaceChannel
     */
    public function setReplaceChannel(Channel $replaceChannel): void
    {
        $this->replaceChannel = $replaceChannel;
    }

    /**
     * @return bool
     */
    public function isExternal(): bool
    {
        return $this->isExternal;
    }

    /**
     * @param bool $isExternal
     */
    public function setIsExternal(bool $isExternal): void
    {
        $this->isExternal = $isExternal;
    }

    /**
     * @return Bridge
     */
    public function getTransfererSecondLegBridge(): Bridge
    {
        return $this->transfererSecondLegBridge;
    }

    /**
     * @param Bridge $transfererSecondLegBridge
     */
    public function setTransfererSecondLegBridge(Bridge $transfererSecondLegBridge): void
    {
        $this->transfererSecondLegBridge = $transfererSecondLegBridge;
    }

    /**
     * @return string
     */
    public function getDestinationBridge(): string
    {
        return $this->destinationBridge;
    }

    /**
     * @param string $destinationBridge
     */
    public function setDestinationBridge(string $destinationBridge): void
    {
        $this->destinationBridge = $destinationBridge;
    }

    /**
     * @return Channel
     */
    public function getTransfererSecondLeg(): Channel
    {
        return $this->transfererSecondLeg;
    }

    /**
     * @param Channel $transfererSecondLeg
     */
    public function setTransfererSecondLeg(Channel $transfererSecondLeg): void
    {
        $this->transfererSecondLeg = $transfererSecondLeg;
    }

    /**
     * @return Channel
     */
    public function getDestinationLinkSecondLeg(): Channel
    {
        return $this->destinationLinkSecondLeg;
    }

    /**
     * @param Channel $destinationLinkSecondLeg
     */
    public function setDestinationLinkSecondLeg(Channel $destinationLinkSecondLeg): void
    {
        $this->destinationLinkSecondLeg = $destinationLinkSecondLeg;
    }

    /**
     * @return Channel
     */
    public function getDestinationThreewayChannel(): Channel
    {
        return $this->destinationThreewayChannel;
    }

    /**
     * @param Channel $destinationThreewayChannel
     */
    public function setDestinationThreewayChannel(Channel $destinationThreewayChannel): void
    {
        $this->destinationThreewayChannel = $destinationThreewayChannel;
    }

    /**
     * @return Channel
     */
    public function getTransferTarget(): Channel
    {
        return $this->transferTarget;
    }

    /**
     * @param Channel $transferTarget
     */
    public function setTransferTarget(Channel $transferTarget): void
    {
        $this->transferTarget = $transferTarget;
    }

    /**
     * @return string
     */
    public function getResult(): string
    {
        return $this->result;
    }

    /**
     * @param string $result
     */
    public function setResult(string $result): void
    {
        $this->result = $result;
    }

    /**
     * @return string
     */
    public function getDestinationType(): string
    {
        return $this->destinationType;
    }

    /**
     * @param string $destinationType
     */
    public function setDestinationType(string $destinationType): void
    {
        $this->destinationType = $destinationType;
    }

    /**
     * @return string
     */
    public function getDestinationApplication(): string
    {
        return $this->destinationApplication;
    }

    /**
     * @param string $destinationApplication
     */
    public function setDestinationApplication(string $destinationApplication): void
    {
        $this->destinationApplication = $destinationApplication;
    }

    /**
     * @return Bridge
     */
    public function getDestinationThreewayBridge(): Bridge
    {
        return $this->destinationThreewayBridge;
    }

    /**
     * @param Bridge $destinationThreewayBridge
     */
    public function setDestinationThreewayBridge(Bridge $destinationThreewayBridge): void
    {
        $this->destinationThreewayBridge = $destinationThreewayBridge;
    }

    /**
     * @return Channel
     */
    public function getDestinationLinkFirstLeg(): Channel
    {
        return $this->destinationLinkFirstLeg;
    }

    /**
     * @param Channel $destinationLinkFirstLeg
     */
    public function setDestinationLinkFirstLeg(Channel $destinationLinkFirstLeg): void
    {
        $this->destinationLinkFirstLeg = $destinationLinkFirstLeg;
    }

    /**
     * @return Channel
     */
    public function getTransferee(): Channel
    {
        return $this->transferee;
    }

    /**
     * @param Channel $transferee
     */
    public function setTransferee(Channel $transferee): void
    {
        $this->transferee = $transferee;
    }

    /**
     * @return Channel
     */
    public function getTransfererFirstLeg(): Channel
    {
        return $this->transfererFirstLeg;
    }

    /**
     * @param Channel $transfererFirstLeg
     */
    public function setTransfererFirstLeg(Channel $transfererFirstLeg): void
    {
        $this->transfererFirstLeg = $transfererFirstLeg;
    }

    /**
     * @return Bridge
     */
    public function getTransfererFirstLegBridge(): Bridge
    {
        return $this->transfererFirstLegBridge;
    }

    /**
     * @param Bridge $transfererFirstLegBridge
     */
    public function setTransfererFirstLegBridge(Bridge $transfererFirstLegBridge): void
    {
        $this->transfererFirstLegBridge = $transfererFirstLegBridge;
    }
}