<?php

/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models;


/**
 * Details of an Asterisk log channel
 *
 * @package AriStasisApp\models
 */
class LogChannel
{
    /**
     * @var string Whether or not a log type is enabled.
     */
    private $status;

    /**
     * @var string The various log levels.
     */
    private $configuration;

    /**
     * @var string Types of logs for the log channel.
     */
    private $type;

    /**
     * @var string The log channel path.
     */
    private $channel;


    /**
     * LogChannel constructor.
     *
     * @param string $status
     * @param string $configuration
     * @param string $type
     * @param string $channel
     */
    function __construct(string $status, string $configuration, string $type, string $channel)
    {
        $this->status = $status;
        $this->configuration = $configuration;
        $this->type = $type;
        $this->channel = $channel;
    }
}