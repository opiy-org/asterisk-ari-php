<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model;

use OpiyOrg\AriClient\Enum\ContactStatus;

/**
 * Detailed information about a contact on an endpoint.
 *
 * @package OpiyOrg\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class ContactInfo implements ModelInterface
{
    public string $uri;

    public string $contactStatus;

    public string $aor;

    public ?string $roundtripUsec = null;

    /**
     * The location of the contact.
     *
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * The current status of the contact.
     *
     * @return string
     * @see ContactStatus
     *
     */
    public function getContactStatus(): string
    {
        return $this->contactStatus;
    }

    /**
     * The Address of Record this contact belongs to.
     *
     * @return string
     */
    public function getAor(): string
    {
        return $this->aor;
    }

    /**
     * Current round trip time, in microseconds, for the contact.
     *
     * @return string|null
     */
    public function getRoundtripUsec(): ?string
    {
        return $this->roundtripUsec;
    }
}
