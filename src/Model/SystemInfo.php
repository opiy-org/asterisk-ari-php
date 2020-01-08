<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Model;

/**
 * Info about Asterisk.
 *
 * @package NgVoice\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class SystemInfo implements ModelInterface
{
    private string $entityId;

    private string $version;

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
