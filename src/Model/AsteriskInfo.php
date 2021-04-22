<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model;

/**
 * Asterisk system information
 *
 * @package OpiyOrg\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class AsteriskInfo implements ModelInterface
{
    private ?StatusInfo $status = null;

    private ?ConfigInfo $config = null;

    private ?BuildInfo $build = null;

    private ?SystemInfo $system = null;

    /**
     * Info about Asterisk status.
     *
     * @return StatusInfo|null
     */
    public function getStatus(): ?StatusInfo
    {
        return $this->status;
    }

    /**
     * Info about Asterisk configuration.
     *
     * @return ConfigInfo|null
     */
    public function getConfig(): ?ConfigInfo
    {
        return $this->config;
    }

    /**
     * Info about how Asterisk was built.
     *
     * @return BuildInfo|null
     */
    public function getBuild(): ?BuildInfo
    {
        return $this->build;
    }

    /**
     * Info about the system running Asterisk.
     *
     * @return SystemInfo|null
     */
    public function getSystem(): ?SystemInfo
    {
        return $this->system;
    }
}
