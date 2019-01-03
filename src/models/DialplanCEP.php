<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models;


/**
 * Dialplan location (context/extension/priority)
 *
 * @package AriStasisApp\models
 */
class DialplanCEP
{
    /**
     * @var string Context in the dialplan
     */
    private $context;

    /**
     * @var string Extension in the dialplan
     */
    private $exten;

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
     * @var string Priority in the dialplan
     */
    private $priority;

}