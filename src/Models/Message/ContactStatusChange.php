<?php

/** @copyright 2019 ng-voice GmbH */

namespace NgVoice\AriClient\Models\Message;

use NgVoice\AriClient\Models\{ContactInfo, Endpoint};

/**
 * The state of a contact on an endpoint has changed.
 *
 * @package NgVoice\AriClient\Models\Message
 */
final class ContactStatusChange extends Event
{
    /**
     * @var Endpoint
     */
    private $endpoint;

    /**
     * @var ContactInfo
     */
    private $contact_info;

    /**
     * @return Endpoint
     */
    public function getEndpoint(): Endpoint
    {
        return $this->endpoint;
    }

    /**
     * @param Endpoint $endpoint
     */
    public function setEndpoint(Endpoint $endpoint): void
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @return ContactInfo
     */
    public function getContactInfo(): ContactInfo
    {
        return $this->contact_info;
    }

    /**
     * @param ContactInfo $contactInfo
     */
    public function setContactInfo(ContactInfo $contactInfo): void
    {
        $this->contact_info = $contactInfo;
    }
}
