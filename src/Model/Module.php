<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\Model;


/**
 * Details of an Asterisk module
 *
 * @package AriStasisApp\Model
 */
class Module
{
    /**
     * @var int The number of times this module is being used.
     * @required
     */
    private $use_count;

    /**
     * @var string The running status of this module.
     * @required
     */
    private $status;

    /**
     * @var string The support state of this module.
     * @required
     */
    private $support_level;

    /**
     * @var string The name of this module.
     * @required
     */
    private $name;

    /**
     * @var string The description of this module.
     * @required
     */
    private $description;

    /**
     * @return int
     */
    public function getUseCount(): int
    {
        return $this->use_count;
    }

    /**
     * @param int $use_count
     */
    public function setUseCount(int $use_count): void
    {
        $this->use_count = $use_count;
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
        return $this->support_level;
    }

    /**
     * @param string $support_level
     */
    public function setSupportLevel(string $support_level): void
    {
        $this->support_level = $support_level;
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