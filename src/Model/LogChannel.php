<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Model;

/**
 * Details of an Asterisk log channel.
 *
 * @package NgVoice\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class LogChannel implements ModelInterface
{
    private string $status;

    private string $configuration;

    private string $type;

    private string $channel;

    /**
     * Whether or not a log type is enabled.
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * The various log levels.
     *
     * @return string
     */
    public function getConfiguration(): string
    {
        return $this->configuration;
    }

    /**
     * Types of logs for the log channel.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * The log channel path.
     *
     * @return string
     */
    public function getChannel(): string
    {
        return $this->channel;
    }
}
