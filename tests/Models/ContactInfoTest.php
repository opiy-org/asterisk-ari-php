<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models;


use JsonMapper_Exception;
use NgVoice\AriClient\Models\{ContactInfo};
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class ContactInfoTest
 *
 * @package NgVoice\AriClient\Tests\Models
 */
final class ContactInfoTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var ContactInfo $contactInfo
         */
        $contactInfo = Helper::mapAriResponseParametersToAriObject(
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
