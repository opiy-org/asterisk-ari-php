<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models;


use JsonMapper_Exception;
use NgVoice\AriClient\Models\StatusInfo;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class StatusInfoTest
 *
 * @package NgVoice\AriClient\Tests\Models
 */
final class StatusInfoTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var StatusInfo $statusInfo
         */
        $statusInfo = Helper::mapAriResponseParametersToAriObject(
            'StatusInfo',
            [
                'startup_time' => '2019-02-19T22:43:31.820+0000',
                'last_reload_time' => '2019-02-19T22:43:31.820+0000'
            ]
        );
        $this->assertSame('2019-02-19T22:43:31.820+0000', $statusInfo->getStartupTime());
        $this->assertSame('2019-02-19T22:43:31.820+0000', $statusInfo->getLastReloadTime());
    }
}
