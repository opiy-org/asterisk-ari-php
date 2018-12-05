<?php
/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models;


/**
 * Details of an Asterisk module
 *
 * @package AriStasisApp\models
 */
class Module
{
    /**
     * @var int The number of times this module is being used.
     */
    private $useCount;

    /**
     * @var string The running status of this module.
     */
    private $status;

    /**
     * @var string The support state of this module.
     */
    private $supportLevel;

    /**
     * @var string The name of this module.
     */
    private $name;

    /**
     * @var string The description of this module.
     */
    private $description;

    /**
     * @return int
     */
    public function getUseCount(): int
    {
        return $this->useCount;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getSupportLevel(): string
    {
        return $this->supportLevel;
    }

    /**
     * @param string $supportLevel
     */
    public function setSupportLevel(string $supportLevel): void
    {
        $this->supportLevel = $supportLevel;
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
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

}