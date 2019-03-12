<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\Model;


require_once __DIR__ . '/../../shared_test_functions.php';

use AriStasisApp\Model\{ContactInfo, Endpoint, Message\ContactStatusChange};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapMessageParametersToAriObject;

/**
 * Class ContactStatusChangeTest
 *
 * @package AriStasisApp\Tests\Model\Message
 */
final class ContactStatusChangeTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
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
        $contactStatusChange = mapMessageParametersToAriObject(
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