<?php

/**
 * The JSONMapper library needs the full name path of
 * a class, so there are no imports used instead.
 *
 * @noinspection PhpFullyQualifiedNameUsageInspection
 */

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Models;


/**
 * Dialplan location (context/extension/priority)
 *
 * @package NgVoice\AriClient\Models
 */
final class DialplanCEP implements Model
{
    /**
     * @var string Priority in the dialplan
     */
    private $priority;

    /**
     * @var string Extension in the dialplan
     */
    private $exten;

    /**
     * @var string Parameter of current dialplan application
     */
    private $app_data;

    /**
     * @var string Name of current dialplan application
     */
    private $app_name;

    /**
     * @var string Context in the dialplan
     */
    private $context;

    /**
     * @return string
     */
    public function getPriority(): string
    {
        return $this->priority;
    }

    /**
     * @param string $priority
     */
    public function setPriority(string $priority): void
    {
        $this->priority = $priority;
    }

    /**
     * @return string
     */
    public function getExten(): string
    {
        return $this->exten;
    }

    /**
     * @param string $exten
     */
    public function setExten(string $exten): void
    {
        $this->exten = $exten;
    }

    /**
     * @return string
     */
    public function getAppData(): string
    {
        return $this->app_data;
    }

    /**
     * @param string $app_data
     */
    public function setAppData(string $app_data): void
    {
        $this->app_data = $app_data;
    }

    /**
     * @return string
     */
    public function getAppName(): string
    {
        return $this->app_name;
    }

    /**
     * @param string $app_name
     */
    public function setAppName(string $app_name): void
    {
        $this->app_name = $app_name;
    }

    /**
     * @return string
     */
    public function getContext(): string
    {
        return $this->context;
    }

    /**
     * @param string $context
     */
    public function setContext(string $context): void
    {
        $this->context = $context;
    }
}
