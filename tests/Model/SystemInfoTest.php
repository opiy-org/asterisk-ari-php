<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;

use NgVoice\AriClient\Model\SystemInfo;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class SystemInfoTest
 *
 * @package NgVoice\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class SystemInfoTest extends TestCase
{
    public const RAW_ARRAY_REPRESENTATION = [
        'version'   => '16.1.0',
        'entity_id' => '02:42:ac:11:00:01',
    ];

    public function testParametersMappedCorrectly(): void
    {
        $systemInfo = new SystemInfo();
        Helper::mapOntoInstance(self::RAW_ARRAY_REPRESENTATION, $systemInfo);

        $this->assertInstanceOf(SystemInfo::class, $systemInfo);
        $this->assertSame('02:42:ac:11:00:01', $systemInfo->getEntityId());
        $this->assertSame('16.1.0', $systemInfo->getVersion());
    }
}
