<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model;

/**
 * Info about Asterisk status.
 *
 * @package OpiyOrg\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class StatusInfo implements ModelInterface
{
    /**
     * @var string Time when Asterisk was last reloaded.
     */
    private string $lastReloadTime;

    /**
     * @var string Time when Asterisk was started.
     */
    private string $startupTime;

    /**
     * @return string
     */
    public function getLastReloadTime(): string
    {
        return $this->lastReloadTime;
    }

    /**
     * @return string
     */
    public function getStartupTime(): string
    {
        return $this->startupTime;
    }
}
