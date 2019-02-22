<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\models;


require_once __DIR__ . '/../shared_test_functions.php';

use AriStasisApp\models\{BuildInfo};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapAriResponseParametersToAriObject;

/**
 * Class BuildInfoTest
 *
 * @package AriStasisApp\Tests\models
 */
final class BuildInfoTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var BuildInfo
         */
        $buildInfo = mapAriResponseParametersToAriObject(
            'BuildInfo',
            [
                'os' => 'Linux',
                'kernel' => '4.9.0-7-amd64',
                'machine' => 'x86_64',
                'options' => 'OPTIONAL_API',
                'date' => '2016-12-20 13:45:28 UTC',
                'user' => 'root'
            ]
        );
        $this->assertSame('root', $buildInfo->getUser());
        $this->assertSame('Linux', $buildInfo->getOs());
        $this->assertSame('2016-12-20 13:45:28 UTC', $buildInfo->getDate());
        $this->assertSame('4.9.0-7-amd64', $buildInfo->getKernel());
        $this->assertSame('x86_64', $buildInfo->getMachine());
        $this->assertSame('OPTIONAL_API', $buildInfo->getOptions());
    }
}