<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model;

/**
 * Info about how Asterisk was built.
 *
 * @package OpiyOrg\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class BuildInfo implements ModelInterface
{
    public string $kernel;

    public string $machine;

    public string $user;

    public string $date;

    public string $os;

    public string $options;

    /**
     * Kernel version Asterisk was built on.
     *
     * @return string
     */
    public function getKernel(): string
    {
        return $this->kernel;
    }

    /**
     * Machine architecture (x86_64, i686, ppc, etc.).
     *
     * @return string
     */
    public function getMachine(): string
    {
        return $this->machine;
    }

    /**
     * Username that built Asterisk.
     *
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * Date and time when Asterisk was built.
     *
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * OS Asterisk was built on.
     *
     * @return string
     */
    public function getOs(): string
    {
        return $this->os;
    }

    /**
     * Compile time options, or empty string if default.
     *
     * @return string
     */
    public function getOptions(): string
    {
        return $this->options;
    }
}
