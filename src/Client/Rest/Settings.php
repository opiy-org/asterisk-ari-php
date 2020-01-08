<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Client\Rest;

use NgVoice\AriClient\Client\AbstractSettings;

/**
 * Encapsulates the settings for a Resource.
 *
 * @package NgVoice\AriClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Settings extends AbstractSettings
{
    /**
     * Flag that says if encryption for the HTTP requests is enabled.
     */
    private bool $httpsEnabled = false;

    /**
     * @return bool
     */
    public function isHttpsEnabled(): bool
    {
        return $this->httpsEnabled;
    }

    /**
     * @param bool $httpsEnabled If HTTPS is enabled in ARI
     */
    public function setHttpsEnabled(bool $httpsEnabled): void
    {
        $this->httpsEnabled = $httpsEnabled;
    }
}
