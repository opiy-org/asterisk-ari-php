<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model;

use OpiyOrg\AriClient\Enum\ChannelStates;
use stdClass;

/**
 * A specific communication connection between Asterisk and an Endpoint.
 *
 * @package OpiyOrg\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class Channel implements ModelInterface
{
    public string $accountcode;

    public string $name;

    public string $language;

    public array $channelvars = [];

    public CallerID $caller;

    public string $creationtime;

    public string $state;

    public CallerID $connected;

    public DialplanCEP $dialplan;

    public string $id;

    /**
     * The account code.
     *
     * @return string
     */
    public function getAccountcode(): string
    {
        return $this->accountcode;
    }

    /**
     * Name of the channel (i.e. SIP/foo-0000a7e3).
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * The default spoken language.
     *
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * Channel variables.
     *
     * @return null|stdClass
     */
    public function getChannelvars(): ?stdClass
    {
        return (object)$this->channelvars;
    }

    /**
     * Get the CallerID.
     *
     * @return CallerID
     */
    public function getCaller(): CallerID
    {
        return $this->caller;
    }

    /**
     * Timestamp when channel was created.
     *
     * @return string
     */
    public function getCreationtime(): string
    {
        return $this->creationtime;
    }

    /**
     * State of the channel.
     *
     * @return string
     * @see ChannelStates
     *
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * Get the connected CallerID.
     *
     * @return CallerID
     */
    public function getConnected(): CallerID
    {
        return $this->connected;
    }

    /**
     * Current location in the dialplan.
     *
     * @return DialplanCEP
     */
    public function getDialplan(): DialplanCEP
    {
        return $this->dialplan;
    }

    /**
     * Unique identifier of the channel.
     *
     * This is the same as the Uniqueid field in AMI.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}
