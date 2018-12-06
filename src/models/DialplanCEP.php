<?php

/**
 * @author Lukas Stermann
 * @author Rick Barenthin
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
    private $extension;

    /**
     * @var string Priority in the dialplan
     */
    private $priority;


    /**
     * DialplanCEP constructor.
     *
     * @param string $context
     * @param string $extension
     * @param string $priority
     */
    function __construct(string $context, string $extension, string $priority)
    {
        $this->context = $context;
        $this->extension = $extension;
        $this->priority = $priority;
    }
}