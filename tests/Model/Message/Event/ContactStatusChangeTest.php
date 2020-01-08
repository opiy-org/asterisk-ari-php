<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model\Message\Event;

use NgVoice\AriClient\Model\ContactInfo;
use NgVoice\AriClient\Model\Endpoint;
use NgVoice\AriClient\Model\Message\Event\ContactStatusChange;
use NgVoice\AriClient\Tests\Helper;
use NgVoice\AriClient\Tests\Model\ContactInfoTest;
use NgVoice\AriClient\Tests\Model\EndpointTest;
use PHPUnit\Framework\TestCase;

/**
 * Class ContactStatusChangeTest
 *
 * @package NgVoice\AriClient\Tests\Model\Event
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
                'endpoint'     => EndpointTest::RAW_ARRAY_REPRESENTATION,
            ]
        );
        $this->assertInstanceOf(Endpoint::class, $contactStatusChange->getEndpoint());
        $this->assertInstanceOf(
            ContactInfo::class,
            $contactStatusChange->getContactInfo()
        );
    }
}
