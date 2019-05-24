<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models;


use JsonMapper_Exception;
use NgVoice\AriClient\Models\SystemInfo;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class SystemInfoTest
 *
 * @package NgVoice\AriClient\Tests\Models
 */
final class SystemInfoTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var SystemInfo $systemInfo
         */
        $systemInfo = Helper::mapAriResponseParametersToAriObject(
            'SystemInfo',
            [
                'version' => '16.1.0',
                'entity_id' => '02:42:ac:11:00:01'
            ]
        );
        $this->assertInstanceOf(SystemInfo::class, $systemInfo);
        $this->assertSame('02:42:ac:11:00:01', $systemInfo->getEntityId());
        $this->assertSame('16.1.0', $systemInfo->getVersion());
    }
}
