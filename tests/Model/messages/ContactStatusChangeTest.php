<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Models\{ContactInfo, Endpoint, Message\ContactStatusChange};
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class ContactStatusChangeTest
 *
 * @package NgVoice\AriClient\Tests\Models\Message
 */
final class ContactStatusChangeTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        $exampleEndpoint = [
            'state' => 'online',
            'technology' => 'ExampleTechnology',
            'channel_ids' => [
                'firstChannel',
                'secondChannel'
            ],
            'resource' => 'ExampleResource'
        ];

        $exampleContactInfo = [
            'aor' => 'ExampleAOR',
            'uri' => 'ExampleUri',
            'roundtrip_usec' => '23',
            'contact_status' => 'Unreachable'
        ];

        /**
         * @var ContactStatusChange $contactStatusChange
         */
        $contactStatusChange = Helper::mapMessageParametersToAriObject(
            'ContactStatusChange',
            [
                'contact_info' => $exampleContactInfo,
                'endpoint' => $exampleEndpoint
            ]
        );
        $this->assertInstanceOf(Endpoint::class, $contactStatusChange->getEndpoint());
        $this->assertInstanceOf(ContactInfo::class, $contactStatusChange->getContactInfo());
    }
}
