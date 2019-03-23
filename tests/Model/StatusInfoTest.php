<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Model\StatusInfo;
use PHPUnit\Framework\TestCase;
use function NgVoice\AriClient\Tests\mapAriResponseParametersToAriObject;

/**
 * Class StatusInfoTest
 *
 * @package NgVoice\AriClient\Tests\Model
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
        $statusInfo = mapAriResponseParametersToAriObject(
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