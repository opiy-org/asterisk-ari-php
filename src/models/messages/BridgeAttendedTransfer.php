<?php

/**
 * @author Lukas Stermann
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
    private $replace_channel;

    /**
     * @var boolean Whether the transfer was externally initiated or not.
     */
    private $is_external;

    /**
     * @var Bridge Bridge the transferer second leg is in.
     */
    private $transferer_second_leg_bridge;

    /**
     * @var string Bridge that survived the merge result.
     */
    private $destination_bridge;

    /**
     * @var Channel Second leg of the transferer.
     */
    private $transferer_second_leg;

    /**
     * @var Channel Second leg of a link transfer result.
     */
    private $destination_link_second_leg;

    /**
     * @var Channel Transferer channel that survived the threeway result.
     */
    private $destination_threeway_channel;

    /**
     * @var Channel The channel that is being transferred to.
     */
    private $transfer_target;

    /**
     * @var string The result of the transfer attempt.
     */
    private $result;

    /**
     * @var string How the transfer was accomplished.
     */
    private $destination_type;

    /**
     * @var string Application that has been transferred into.
     */
    private $destination_application;

    /**
     * @var Bridge Bridge that survived the threeway result.
     */
    private $destination_threeway_bridge;

    /**
     * @var Channel First leg of a link transfer result.
     */
    private $destination_link_first_leg;

    /**
     * @var Channel The channel that is being transferred.
     */
    private $transferee;

    /**
     * @var Channel First leg of the transferer.
     */
    private $transferer_first_leg;

    /**
     * @var Bridge Bridge the transferer first leg is in.
     */
    private $transferer_first_leg_bridge;

    /**
     * @return Channel
     */
    public function getReplaceChannel(): Channel
    {
        return $this->replace_channel;
    }

    /**
     * @param Channel $replace_channel
     */
    public function setReplaceChannel(Channel $replace_channel): void
    {
        $this->replace_channel = $replace_channel;
    }

    /**
     * @return bool
     */
    public function isExternal(): bool
    {
        return $this->is_external;
    }

    /**
     * @param bool $is_external
     */
    public function setIsExternal(bool $is_external): void
    {
        $this->is_external = $is_external;
    }

    /**
     * @return Bridge
     */
    public function getTransfererSecondLegBridge(): Bridge
    {
        return $this->transferer_second_leg_bridge;
    }

    /**
     * @param Bridge $transferer_second_leg_bridge
     */
    public function setTransfererSecondLegBridge(Bridge $transferer_second_leg_bridge): void
    {
        $this->transferer_second_leg_bridge = $transferer_second_leg_bridge;
    }

    /**
     * @return string
     */
    public function getDestinationBridge(): string
    {
        return $this->destination_bridge;
    }

    /**
     * @param string $destination_bridge
     */
    public function setDestinationBridge(string $destination_bridge): void
    {
        $this->destination_bridge = $destination_bridge;
    }

    /**
     * @return Channel
     */
    public function getTransfererSecondLeg(): Channel
    {
        return $this->transferer_second_leg;
    }

    /**
     * @param Channel $transferer_second_leg
     */
    public function setTransfererSecondLeg(Channel $transferer_second_leg): void
    {
        $this->transferer_second_leg = $transferer_second_leg;
    }

    /**
     * @return Channel
     */
    public function getDestinationLinkSecondLeg(): Channel
    {
        return $this->destination_link_second_leg;
    }

    /**
     * @param Channel $destination_link_second_leg
     */
    public function setDestinationLinkSecondLeg(Channel $destination_link_second_leg): void
    {
        $this->destination_link_second_leg = $destination_link_second_leg;
    }

    /**
     * @return Channel
     */
    public function getDestinationThreewayChannel(): Channel
    {
        return $this->destination_threeway_channel;
    }

    /**
     * @param Channel $destination_threeway_channel
     */
    public function setDestinationThreewayChannel(Channel $destination_threeway_channel): void
    {
        $this->destination_threeway_channel = $destination_threeway_channel;
    }

    /**
     * @return Channel
     */
    public function getTransferTarget(): Channel
    {
        return $this->transfer_target;
    }

    /**
     * @param Channel $transfer_target
     */
    public function setTransferTarget(Channel $transfer_target): void
    {
        $this->transfer_target = $transfer_target;
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
        return $this->destination_type;
    }

    /**
     * @param string $destination_type
     */
    public function setDestinationType(string $destination_type): void
    {
        $this->destination_type = $destination_type;
    }

    /**
     * @return string
     */
    public function getDestinationApplication(): string
    {
        return $this->destination_application;
    }

    /**
     * @param string $destination_application
     */
    public function setDestinationApplication(string $destination_application): void
    {
        $this->destination_application = $destination_application;
    }

    /**
     * @return Bridge
     */
    public function getDestinationThreewayBridge(): Bridge
    {
        return $this->destination_threeway_bridge;
    }

    /**
     * @param Bridge $destination_threeway_bridge
     */
    public function setDestinationThreewayBridge(Bridge $destination_threeway_bridge): void
    {
        $this->destination_threeway_bridge = $destination_threeway_bridge;
    }

    /**
     * @return Channel
     */
    public function getDestinationLinkFirstLeg(): Channel
    {
        return $this->destination_link_first_leg;
    }

    /**
     * @param Channel $destination_link_first_leg
     */
    public function setDestinationLinkFirstLeg(Channel $destination_link_first_leg): void
    {
        $this->destination_link_first_leg = $destination_link_first_leg;
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
        return $this->transferer_first_leg;
    }

    /**
     * @param Channel $transferer_first_leg
     */
    public function setTransfererFirstLeg(Channel $transferer_first_leg): void
    {
        $this->transferer_first_leg = $transferer_first_leg;
    }

    /**
     * @return Bridge
     */
    public function getTransfererFirstLegBridge(): Bridge
    {
        return $this->transferer_first_leg_bridge;
    }

    /**
     * @param Bridge $transferer_first_leg_bridge
     */
    public function setTransfererFirstLegBridge(Bridge $transferer_first_leg_bridge): void
    {
        $this->transferer_first_leg_bridge = $transferer_first_leg_bridge;
    }
}