<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model\Message\Event;

use OpiyOrg\AriClient\Model\ContactInfo;
use OpiyOrg\AriClient\Model\Endpoint;
use OpiyOrg\AriClient\Model\Message\Event\ContactStatusChange;
use OpiyOrg\AriClient\Tests\Helper;
use OpiyOrg\AriClient\Tests\Model\ContactInfoTest;
use OpiyOrg\AriClient\Tests\Model\EndpointTest;
use PHPUnit\Framework\TestCase;

/**
 * Class ContactStatusChangeTest
 *
 * @package OpiyOrg\AriClient\Tests\Model\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ContactStatusChangeTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var ContactStatusChange $contactStatusChange
         */
        $contactStatusChange = Helper::mapOntoAriEvent(
            ContactStatusChange::class,
            [
                'contact_info' => ContactInfoTest::RAW_ARRAY_REPRESENTATION,
                'endpoint' => EndpointTest::RAW_ARRAY_REPRESENTATION,
            ]
        );
        $this->assertInstanceOf(Endpoint::class, $contactStatusChange->getEndpoint());
        $this->assertInstanceOf(
            ContactInfo::class,
            $contactStatusChange->getContactInfo()
        );
    }
}
