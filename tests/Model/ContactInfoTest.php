<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\Model;


require_once __DIR__ . '/../shared_test_functions.php';

use AriStasisApp\Model\{ContactInfo};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapAriResponseParametersToAriObject;

/**
 * Class ContactInfoTest
 *
 * @package AriStasisApp\Tests\Model
 */
final class ContactInfoTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var ContactInfo $contactInfo
         */
        $contactInfo = mapAriResponseParametersToAriObject(
            'ContactInfo',
            [
                'aor' => 'ExampleAOR',
                'uri' => 'ExampleUri',
                'roundtrip_usec' => '23',
                'contact_status' => 'Unreachable'
            ]
        );
        $this->assertSame('ExampleAOR', $contactInfo->getAor());
        $this->assertSame('Unreachable', $contactInfo->getContactStatus());
        $this->assertSame('23', $contactInfo->getRoundtripUsec());
        $this->assertSame('ExampleUri', $contactInfo->getUri());
    }
}