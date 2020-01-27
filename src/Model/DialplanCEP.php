<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Model;

/**
 * Dialplan location (context/extension/priority)
 *
 * @package NgVoice\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class DialplanCEP implements ModelInterface
{
    /**
     * @var mixed
     */
    private $priority;

    private string $exten;

    private ?string $appData = null;

    private ?string $appName = null;

    private string $context;

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
