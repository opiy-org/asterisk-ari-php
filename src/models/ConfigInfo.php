<?php
/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models;


/**
 * Info about Asterisk configuration
 *
 * @package AriStasisApp\models
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
    private $defaultLanguage;

    /**
     * @var double Maximum load avg on system.
     */
    private $maxLoad;

    /**
     * @var SetId Effective user/group id for running Asterisk.
     */
    private $setid;

    /**
     * @var int Maximum number of open file handles (files, sockets).
     */
    private $maxOpenFiles;

    /**
     * @var int Maximum number of simultaneous channels.
     */
    private $maxChannels;

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
        return $this->defaultLanguage;
    }

    /**
     * @param string $defaultLanguage
     */
    public function setDefaultLanguage(string $defaultLanguage): void
    {
        $this->defaultLanguage = $defaultLanguage;
    }

    /**
     * @return float
     */
    public function getMaxLoad(): float
    {
        return $this->maxLoad;
    }

    /**
     * @param float $maxLoad
     */
    public function setMaxLoad(float $maxLoad): void
    {
        $this->maxLoad = $maxLoad;
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
        return $this->maxOpenFiles;
    }

    /**
     * @param int $maxOpenFiles
     */
    public function setMaxOpenFiles(int $maxOpenFiles): void
    {
        $this->maxOpenFiles = $maxOpenFiles;
    }

    /**
     * @return int
     */
    public function getMaxChannels(): int
    {
        return $this->maxChannels;
    }

    /**
     * @param int $maxChannels
     */
    public function setMaxChannels(int $maxChannels): void
    {
        $this->maxChannels = $maxChannels;
    }
}