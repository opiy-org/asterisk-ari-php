<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\Model;


/**
 * Info about Asterisk configuration
 *
 * @package NgVoice\AriClient\Model
 */
class ConfigInfo
{
    /**
     * @var string Asterisk system name.
     */
    private $name;

    /**
     * @var string Default language for media playback.
     */
    private $default_language;

    /**
     * @var double Maximum load avg on system.
     */
    private $max_load;

    /**
     * @var SetId Effective user/group id for running Asterisk.
     */
    private $setid;

    /**
     * @var int Maximum number of open file handles (files, sockets).
     */
    private $max_open_files;

    /**
     * @var int Maximum number of simultaneous channels.
     */
    private $max_channels;

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
    public function getDefaultLanguage(): string
    {
        return $this->default_language;
    }

    /**
     * @param string $defaultLanguage
     */
    public function setDefaultLanguage(string $defaultLanguage): void
    {
        $this->default_language = $defaultLanguage;
    }

    /**
     * @return float
     */
    public function getMaxLoad(): float
    {
        return $this->max_load;
    }

    /**
     * @param float $maxLoad
     */
    public function setMaxLoad(float $maxLoad): void
    {
        $this->max_load = $maxLoad;
    }

    /**
     * @return SetId
     */
    public function getSetid(): SetId
    {
        return $this->setid;
    }

    /**
     * @param SetId $setid
     */
    public function setSetid(SetId $setid): void
    {
        $this->setid = $setid;
    }

    /**
     * @return int
     */
    public function getMaxOpenFiles(): int
    {
        return $this->max_open_files;
    }

    /**
     * @param int $maxOpenFiles
     */
    public function setMaxOpenFiles(int $maxOpenFiles): void
    {
        $this->max_open_files = $maxOpenFiles;
    }

    /**
     * @return int
     */
    public function getMaxChannels(): int
    {
        return $this->max_channels;
    }

    /**
     * @param int $maxChannels
     */
    public function setMaxChannels(int $maxChannels): void
    {
        $this->max_channels = $maxChannels;
    }
}