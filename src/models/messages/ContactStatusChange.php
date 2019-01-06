<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models\messages;


use AriStasisApp\models\ContactInfo;
use AriStasisApp\models\Endpoint;

/**
 * The state of a contact on an endpoint has changed.
 *
 * @package AriStasisApp\models\messages
 */
class ContactStatusChange extends Event
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