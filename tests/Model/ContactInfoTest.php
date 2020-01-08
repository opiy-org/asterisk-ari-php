<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;

use NgVoice\AriClient\Model\{ContactInfo};
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class ContactInfoTest
 *
 * @package NgVoice\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ContactInfoTest extends TestCase
{
    public const RAW_ARRAY_REPRESENTATION = [
        'aor'            => 'ExampleAOR',
        'uri'            => 'ExampleUri',
        'roundtrip_usec' => '23',
        'contact_status' => 'Unreachable',
    ];

    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var ContactInfo $contactInfo
         */
        $contactInfo = Helper::mapOntoInstance(
            self::RAW_ARRAY_REPRESENTATION,
            new ContactInfo()
        );
        $this->assertSame('ExampleAOR', $contactInfo->getAor());
        $this->assertSame('Unreachable', $contactInfo->getContactStatus());
        $this->assertSame('23', $contactInfo->getRoundtripUsec());
        $this->assertSame('ExampleUri', $contactInfo->getUri());
    }
}
