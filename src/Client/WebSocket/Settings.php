<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Client\WebSocket;

use Closure;
use NgVoice\AriClient\Client\AbstractSettings;
use NgVoice\AriClient\Client\Rest\Resource\Applications;

/**
 * Encapsulates settings for a web socket client.
 *
 * @package NgVoice\AriClient\Client\WebSocket
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Settings extends AbstractSettings
{
    private bool $isSubscribeAll = false;

    private bool $wssEnabled = false;

    private ?Closure $errorHandler = null;

    private ?Applications $ariApplicationsClient = null;

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


    /**
     * Check, if the Stasis application subscribes to all ARI events,
     * effectively disabling the application specific subscriptions.
     *
     * @return bool Flag, indicating if the this application should
     * subscribe to all Asterisk REST Interface events
     */
    public function isSubscribeAll(): bool
    {
        return $this->isSubscribeAll;
    }

    /**
     * Set the option to subscribe to all Asterisk REST Interface events,
     * effectively disabling the application specific subscriptions.
     *
     * @param $subscribeAll bool Flag, indicating if the this application should
     * subscribe to all Asterisk REST Interface events
     */
    public function setIsSubscribeAll(bool $subscribeAll): void
    {
        $this->isSubscribeAll = $subscribeAll;
    }

    /**
     * Get the ARI Applications REST client for event filtering on web socket connection.
     *
     * @return Applications|null The REST client
     */
    public function getAriApplicationsClient(): ?Applications
    {
        return $this->ariApplicationsClient;
    }

    /**
     * Set the ARI Applications REST client for event filtering on web socket connection.
     *
     * @param Applications $ariApplicationsClient The REST client
     */
    public function setAriApplicationsClient(?Applications $ariApplicationsClient): void
    {
        $this->ariApplicationsClient = $ariApplicationsClient;
    }
}
