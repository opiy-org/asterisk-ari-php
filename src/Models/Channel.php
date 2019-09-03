<?php

/**
 * The JSONMapper library needs the full name path of
 * a class, so there are no imports used instead.
 *
 * @noinspection PhpFullyQualifiedNameUsageInspection
 */

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Models;


/**
 * A specific communication connection between Asterisk and an Endpoint.
 *
 * @package NgVoice\AriClient\Models
 */
final class Channel implements Model
{
    // Channel states
    public const DOWN = 'Down';

    public const RESERVED = 'Rsrved';

    public const OFF_HOOK = 'OffHook';

    public const DIALING = 'Dialing';

    public const RING = 'Ring';

    public const RINGING = 'Ringing';

    public const UP = 'Up';

    public const BUSY = 'Busy';

    public const DIALING_OFF_HOOK = 'Dialing OffHook';

    public const PRE_RING = 'Pre-ring';

    public const UNKNOWN = 'Unknown';

    /**
     * @var string
     */
    private $accountcode;

    /**
     * Name of the channel (i.e. SIP/foo-0000a7e3)
     *
     * @var string
     */
    private $name;

    /**
     * The default spoken language.
     *
     * @var string
     */
    private $language;

    /**
     * Channels variables.
     *
     * @var object Channel variables.
     */
    private $channelvars;

    /**
     * @var CallerID
     */
    private $caller;

    /**
     * Timestamp when channel was created.
     *
     * @var string
     */
    private $creationtime;

    /**
     * State of the channel.
     *
     * @var string Possible values: ["Down", "Rsrved", "OffHook", "Dialing", "Ring", "Ringing",
     * "Up", "Busy", "Dialing Offhook", "Pre-ring", "Unknown"]
     */
    private $state;

    /**
     * @var CallerID
     */
    private $connected;

    /**
     * Current location in the dialplan.
     *
     * @var DialplanCEP
     */
    private $dialplan;

    /**
     * Unique identifier of the channel. This is the same as the Uniqueid field in AMI.
     *
     * @var string
     */
    private $id;

    /**
     * @return string
     */
    public function getAccountcode(): string
    {
        return $this->accountcode;
    }

    /**
     * @param string $accountcode
     */
    public function setAccountcode(string $accountcode): void
    {
        $this->accountcode = $accountcode;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    /**
     * @return null|object
     */
    public function getChannelvars(): object
    {
        return $this->channelvars;
    }

    /**
     * @param object $channelvars
     */
    public function setChannelvars(object $channelvars): void
    {
        $this->channelvars = $channelvars;
    }

    /**
     * @return CallerID
     */
    public function getCaller(): CallerID
    {
        return $this->caller;
    }

    /**
     * @param CallerID $caller
     */
    public function setCaller(CallerID $caller): void
    {
        $this->caller = $caller;
    }

    /**
     * @return string
     */
    public function getCreationtime(): string
    {
        return $this->creationtime;
    }

    /**
     * @param string $creationtime
     */
    public function setCreationtime(string $creationtime): void
    {
        $this->creationtime = $creationtime;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState(string $state): void
    {
        $this->state = $state;
    }

    /**
     * @return CallerID
     */
    public function getConnected(): CallerID
    {
        return $this->connected;
    }

    /**
     * @param CallerID $connected
     */
    public function setConnected(CallerID $connected): void
    {
        $this->connected = $connected;
    }

    /**
     * @return DialplanCEP
     */
    public function getDialplan(): DialplanCEP
    {
        return $this->dialplan;
    }

    /**
     * @param DialplanCEP $dialplan
     */
    public function setDialplan(DialplanCEP $dialplan): void
    {
        $this->dialplan = $dialplan;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }
}
