<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model;

use OpiyOrg\AriClient\Model\{BuildInfo};
use OpiyOrg\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class BuildInfoTest
 *
 * @package OpiyOrg\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class BuildInfoTest extends TestCase
{
    public const RAW_ARRAY_REPRESENTATION = [
        'os'      => 'Linux',
        'kernel'  => '4.9.0-7-amd64',
        'machine' => 'x86_64',
        'options' => 'OPTIONAL_API',
        'date'    => '2016-12-20 13:45:28 UTC',
        'user'    => 'root',
    ];

    public function testParametersMappedCorrectly(): void
    {
        $buildInfo = new BuildInfo();
        Helper::mapOntoInstance(self::RAW_ARRAY_REPRESENTATION, $buildInfo);

        $this->assertSame('root', $buildInfo->getUser());
        $this->assertSame('Linux', $buildInfo->getOs());
        $this->assertSame('2016-12-20 13:45:28 UTC', $buildInfo->getDate());
        $this->assertSame('4.9.0-7-amd64', $buildInfo->getKernel());
        $this->assertSame('x86_64', $buildInfo->getMachine());
        $this->assertSame('OPTIONAL_API', $buildInfo->getOptions());
    }
}
