<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model;

/**
 * Info about Asterisk.
 *
 * @package OpiyOrg\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class SystemInfo implements ModelInterface
{
    public string $entityId;

    public string $version;

    /**
     * Entities id.
     *
     * @return string
     */
    public function getEntityId(): string
    {
        return $this->entityId;
    }

    /**
     * Asterisk version.
     *
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }
}
