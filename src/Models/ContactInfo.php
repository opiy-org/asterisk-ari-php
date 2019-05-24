<?php

/**
 * The JSONMapper library needs the full name path of
 * a class, so there are no imports used instead.
 *
 * @noinspection PhpFullyQualifiedNameUsageInspection
 */

/** @copyright 2019 ng-voice GmbH */

namespace NgVoice\AriClient\Models;


/**
 * Detailed information about a contact on an endpoint.
 *
 * @package NgVoice\AriClient\Models
 */
final class ContactInfo implements Model
{
    /**
     * @var string The location of the contact.
     */
    private $uri;

    /**
     * @var string The current status of the contact.
     * Either ("Unreachable", "Reachable", "Unknown", "NonQualified", "Removed")
     */
    private $contact_status;

    /**
     * @var string The Address of Record this contact belongs to.
     */
    private $aor;

    /**
     * @var string Current round trip time, in microseconds, for the contact.
     */
    private $roundtrip_usec;

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     */
    public function setUri(string $uri): void
    {
        $this->uri = $uri;
    }

    /**
     * @return string
     */
    public function getContactStatus(): string
    {
        return $this->contact_status;
    }

    /**
     * @param string $contact_status
     */
    public function setContactStatus(string $contact_status): void
    {
        $this->contact_status = $contact_status;
    }

    /**
     * @return string
     */
    public function getAor(): string
    {
        return $this->aor;
    }

    /**
     * @param string $aor
     */
    public function setAor(string $aor): void
    {
        $this->aor = $aor;
    }

    /**
     * @return string
     */
    public function getRoundtripUsec(): string
    {
        return $this->roundtrip_usec;
    }

    /**
     * @param string $roundtrip_usec
     */
    public function setRoundtripUsec(string $roundtrip_usec): void
    {
        $this->roundtrip_usec = $roundtrip_usec;
    }
}
