<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\Model;


/**
 * Info about how Asterisk was built.
 *
 * @package AriStasisApp\Model
 */
class BuildInfo
{
    /**
     * @var string Kernel version Asterisk was built on.
     */
    private $kernel;

    /**
     * @var string Machine architecture (x86_64, i686, ppc, etc.).
     */
    private $machine;

    /**
     * @var string Username that built Asterisk.
     */
    private $user;

    /**
     * @var string Date and time when Asterisk was built.
     */
    private $date;

    /**
     * @var string OS Asterisk was built on.
     */
    private $os;

    /**
     * @var string Compile time options, or empty string if default.
     */
    private $options;

    /**
     * @return string
     */
    public function getKernel(): string
    {
        return $this->kernel;
    }

    /**
     * @param string $kernel
     */
    public function setKernel(string $kernel): void
    {
        $this->kernel = $kernel;
    }

    /**
     * @return string
     */
    public function getMachine(): string
    {
        return $this->machine;
    }

    /**
     * @param string $machine
     */
    public function setMachine(string $machine): void
    {
        $this->machine = $machine;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @param string $user
     */
    public function setUser(string $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getOs(): string
    {
        return $this->os;
    }

    /**
     * @param string $os
     */
    public function setOs(string $os): void
    {
        $this->os = $os;
    }

    /**
     * @return string
     */
    public function getOptions(): string
    {
        return $this->options;
    }

    /**
     * @param string $options
     */
    public function setOptions(string $options): void
    {
        $this->options = $options;
    }
}