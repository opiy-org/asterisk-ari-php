<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\models;


require_once __DIR__ . '/../shared_test_functions.php';

use AriStasisApp\models\{AsteriskInfo, BuildInfo, ConfigInfo, StatusInfo, SystemInfo};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapAriResponseParametersToAriObject;

/**
 * Class AsteriskInfoTest
 *
 * @package AriStasisApp\Tests\models
 */
final class AsteriskInfoTest extends TestCase
{
    /*
     * All of the AsteriskInfo Elements are tested in their own tests.
     * We therefore do not need an extra test for this class.
     */

    /**
     * @throws \JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var AsteriskInfo $asteriskInfo
         */
        $asteriskInfo = mapAriResponseParametersToAriObject(
            'AsteriskInfo',
            [
                'build' => [
                    'os' => 'Linux',
                    'kernel' => '4.9.0-7-amd64',
                    'machine' => 'x86_64',
                    'options' => 'OPTIONAL_API',
                    'date' => '2016-12-20 13:45:28 UTC',
                    'user' => 'root'
                ],

                'system' => [
                    'version' => '16.1.0',
                    'entity_id' => '02:42:ac:11:00:01'
                ],

                'config' => [
                    'name' => '',
                    'default_language' => 'en',
                    'setid' => [
                        'user' => '',
                        'group' => ''
                    ]
                ],

                'status' => [
                    'startup_time' => '2019-02-19T22:43:31.820+0000',
                    'last_reload_time' => '2019-02-19T22:43:31.820+0000'
                ]
            ]
        );
        $this->assertInstanceOf(StatusInfo::class, $asteriskInfo->getStatus());
        $this->assertInstanceOf(SystemInfo::class, $asteriskInfo->getSystem());
        $this->assertInstanceOf(ConfigInfo::class, $asteriskInfo->getConfig());
        $this->assertInstanceOf(BuildInfo::class, $asteriskInfo->getBuild());
    }
}