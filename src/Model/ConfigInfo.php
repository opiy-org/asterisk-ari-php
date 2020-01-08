<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Model;

/**
 * Info about Asterisk configuration.
 *
 * @package NgVoice\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ConfigInfo implements ModelInterface
{
    private string $name;

    private string $defaultLanguage;

    private ?float $maxLoad = null;

    private SetId $setid;

    private ?int $maxOpenFiles = null;

    private ?int $maxChannels = null;

    /**
     * Asterisk system name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Default language for media playback.
     *
     * @return string
     */
    public function getDefaultLanguage(): string
    {
        return $this->defaultLanguage;
    }

    /**
     * Maximum load avg on system.
     *
     * @return float|null
     */
    public function getMaxLoad(): ?float
    {
        return $this->maxLoad;
    }

    /**
     * Effective user/group id for running Asterisk.
     *
     * @return SetId
     */
    public function getSetid(): SetId
    {
        return $this->setid;
    }

    /**
     * Maximum number of open file handles (files, sockets).
     *
     * @return int|null
     */
    public function getMaxOpenFiles(): ?int
    {
        return $this->maxOpenFiles;
    }

    /**
     * Maximum number of simultaneous channels.
     *
     * @return int|null
     */
    public function getMaxChannels(): ?int
    {
        return $this->maxChannels;
    }
}
