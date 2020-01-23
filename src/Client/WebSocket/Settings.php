<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Client\WebSocket;

use Closure;
use NgVoice\AriClient\Client\AbstractSettings;

/**
 * Encapsulates settings for a web socket client.
 *
 * @package NgVoice\AriClient\Client\WebSocket
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Settings extends AbstractSettings
{
    private bool $wssEnabled = false;

    private ?Closure $errorHandler = null;

    /**
     * Check, if WSS is enabled.
     *
     * @return bool Flag, indicating if encryption
     * for the web socket requests is enabled.
     */
    public function isWssEnabled(): bool
    {
        return $this->wssEnabled;
    }

    /**
     * Set, if WSS is enabled.
     *
     * @param bool $wssEnabled Flag, indicating if
     * encryption for the web socket requests is enabled.
     */
    public function setWssEnabled(bool $wssEnabled): void
    {
        $this->wssEnabled = $wssEnabled;
    }

    /**
     * Get the web socket error handler.
     *
     * Anonymous function, which contains the logic that executes when uncaught
     * Throwables are thrown within your Stasis application or the web socket
     * client itself. This is the last error handler layer before the error
     * handler of the process itself.
     *
     * @return Closure|null The handler, which shall be called on an error
     */
    public function getErrorHandler(): ?Closure
    {
        return $this->errorHandler;
    }

    /**
     * Set the anonymous function, which contains the logic that executes
     * when uncaught Throwables are thrown within your Stasis application.
     *
     * @param Closure|null $errorHandler The handler to call on an error
     */
    public function setErrorHandler(?Closure $errorHandler): void
    {
        $this->errorHandler = $errorHandler;
    }
}
