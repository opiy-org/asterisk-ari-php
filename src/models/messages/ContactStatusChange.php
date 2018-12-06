<?php

/**
 * @author Lukas Stermann
 * @author Rick Barenthin
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
    private $contactInfo;

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
        return $this->contactInfo;
    }

    /**
     * @param ContactInfo $contactInfo
     */
    public function setContactInfo(ContactInfo $contactInfo): void
    {
        $this->contactInfo = $contactInfo;
    }
}