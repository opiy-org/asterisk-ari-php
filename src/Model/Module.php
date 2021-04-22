<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model;

/**
 * Details of an Asterisk module.
 *
 * @package OpiyOrg\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Module implements ModelInterface
{
    private int $useCount;

    private string $status;

    private string $supportLevel;

    private string $name;

    private string $description;

    /**
     * The number of times this module is being used.
     *
     * @return int
     */
    public function getUseCount(): int
    {
        return $this->useCount;
    }

    /**
     * The running status of this module.
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * The support state of this module.
     *
     * @return string
     */
    public function getSupportLevel(): string
    {
        return $this->supportLevel;
    }

    /**
     * The name of this module.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * The description of this module.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
