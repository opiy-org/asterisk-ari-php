<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\Model\Message;


use NgVoice\AriClient\Model\{Bridge, Channel};

/**
 * Notification that a blind transfer has occurred.
 *
 * @package NgVoice\AriClient\Model\Message
 */
class BridgeBlindTransfer extends Event
{
    /**
     * @var Bridge The bridge being transferred.
     */
    private $bridge;

    /**
     * @var Channel The channel that is replacing transferer when the transferee(s) can not be transferred directly.
     */
    private $replace_channel;

    /**
     * @var boolean Whether the transfer was externally initiated or not.
     */
    private $is_external;

    /**
     * @var string The extension transferred to.
     */
    private $exten;

    /**
     * @var string The result of the transfer attempt.
     */
    private $result;

    /**
     * @var string The context transferred to.
     */
    private $context;

    /**
     * @var Channel The channel that is being transferred.
     */
    private $transferee;

    /**
     * @var Channel The channel performing the blind transfer.
     */
    private $channel;

    /**
     * @return Bridge
     */
    public function getBridge(): Bridge
    {
        return $this->bridge;
    }

    /**
     * @param Bridge $bridge
     */
    public function setBridge(Bridge $bridge): void
    {
        $this->bridge = $bridge;
    }

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
     * @return string
     */
    public function getExten(): string
    {
        return $this->exten;
    }

    /**
     * @param string $exten
     */
    public function setExten(string $exten): void
    {
        $this->exten = $exten;
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
    public function getContext(): string
    {
        return $this->context;
    }

    /**
     * @param string $context
     */
    public function setContext(string $context): void
    {
        $this->context = $context;
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
    public function getChannel(): Channel
    {
        return $this->channel;
    }

    /**
     * @param Channel $channel
     */
    public function setChannel(Channel $channel): void
    {
        $this->channel = $channel;
    }

}