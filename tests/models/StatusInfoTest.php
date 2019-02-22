<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\models;


require_once __DIR__ . '/../shared_test_functions.php';

use AriStasisApp\models\StatusInfo;
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapAriResponseParametersToAriObject;

/**
 * Class StatusInfoTest
 *
 * @package AriStasisApp\Tests\models
 */
final class StatusInfoTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
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