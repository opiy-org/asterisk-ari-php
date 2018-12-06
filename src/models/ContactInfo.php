<?php

/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 */


namespace AriStasisApp\models;


/**
 * Detailed information about a contact on an endpoint.
 *
 * @package AriStasisApp\models
 */
class ContactInfo
{
    /**
     * @var string The location of the contact.
     */
    private $uri;

    /**
     * @var string The current status of the contact.
     * Either ("Unreachable", "Reachable", "Unknown", "NonQualified", "Removed")
     */
    private $contactStatus;

    /**
     * @var string The Address of Record this contact belongs to.
     */
    private $aor;

    /**
     * @var string Current round trip time, in microseconds, for the contact.
     */
    private $roundtripUsec;


    /**
     * ContactInfo constructor.
     *
     * @param string $uri
     * @param string $contactStatus
     * @param string $aor
     * @param string $roundtripUsec
     */
    function __construct(string $uri, string $contactStatus, string $aor, string $roundtripUsec)
    {
        $this->uri = $uri;
        $this->contactStatus = $contactStatus;
        $this->aor = $aor;
        $this->roundtripUsec = $roundtripUsec;
    }
}