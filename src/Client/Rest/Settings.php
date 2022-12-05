<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Client\Rest;

use OpiyOrg\AriClient\Client\AbstractSettings;

/**
 * Encapsulates the settings for a Resource.
 *
 * @package OpiyOrg\AriClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class Settings extends AbstractSettings
{
    private bool $httpsEnabled = false;

    /**
     * Get the HTTPS enabled options value.
     *
     * @return bool Flag, indicating if encryption is enabled
     * for HTTP calls to the Asterisk REST Interface.
     */
    public function isHttpsEnabled(): bool
    {
        return $this->httpsEnabled;
    }

    /**
     * @param bool $httpsEnabled Flag, indicating if encryption
     * for HTTP calls to the Asterisk REST Interface must be enabled.
     */
    public function setHttpsEnabled(bool $httpsEnabled): void
    {
        $this->httpsEnabled = $httpsEnabled;
    }
}
