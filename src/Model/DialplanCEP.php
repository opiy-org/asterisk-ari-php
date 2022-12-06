<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model;

/**
 * Dialplan location (context/extension/priority)
 *
 * @package OpiyOrg\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class DialplanCEP implements ModelInterface
{
    /**
     * @var mixed
     */
    public $priority;

    public string $exten;

    public ?string $appData = null;

    public ?string $appName = null;

    public string $context;

    /**
     * Priority in the dialplan.
     *
     * @return mixed
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Extension in the dialplan.
     *
     * @return string
     */
    public function getExten(): string
    {
        return $this->exten;
    }

    /**
     * Parameter of current dialplan application.
     *
     * @return string|null
     */
    public function getAppData(): ?string
    {
        return $this->appData;
    }

    /**
     * Name of current dialplan application.
     *
     * @return string|null
     */
    public function getAppName(): ?string
    {
        return $this->appName;
    }

    /**
     * Context in the dialplan.
     *
     * @return string
     */
    public function getContext(): string
    {
        return $this->context;
    }
}
