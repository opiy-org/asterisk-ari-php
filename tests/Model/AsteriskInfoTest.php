<?php

/**
 * @copyright 2020 ng-voice GmbH
 *
 * @noinspection UnknownInspectionInspection The [EA] plugin for PhpStorm doesn't know
 * about the noinspection annotation.
 * @noinspection ClassMockingCorrectnessInspection We are using a dependency to hook
 * onto classes before the tests in order to remove the 'final' class keyword. This makes
 * the classes extendable for PhpUnit and therefore testable.
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\Model;

use OpiyOrg\AriClient\Model\{AsteriskInfo, BuildInfo, ConfigInfo, StatusInfo, SystemInfo};
use OpiyOrg\AriClient\Tests\Helper;
use OpiyOrg\AriClient\Tests\Model\BuildInfoTest;
use OpiyOrg\AriClient\Tests\Model\ConfigInfoTest;
use OpiyOrg\AriClient\Tests\Model\StatusInfoTest;
use OpiyOrg\AriClient\Tests\Model\SystemInfoTest;
use PHPUnit\Framework\TestCase;

/**
 * Class AsteriskInfoTest
 *
 * @package OpiyOrg\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class AsteriskInfoTest extends TestCase
{
    private AsteriskInfo $asteriskInfo;

    public function setUp(): void
    {
        $this->asteriskInfo = new AsteriskInfo();
    }

    public function testCreate(): void
    {
        $this->assertInstanceOf(AsteriskInfo::class, $this->asteriskInfo);
    }

    public function testSetAndGetStatusInfo(): void
    {
        $statusInfo = StatusInfoTest::RAW_ARRAY_REPRESENTATION;

        Helper::mapOntoInstance(['status' => $statusInfo], $this->asteriskInfo);

        $this->assertInstanceOf(StatusInfo::class, $this->asteriskInfo->getStatus());
    }

    public function testSetAndGetConfigInfo(): void
    {
        $configInfo = ConfigInfoTest::RAW_ARRAY_REPRESENTATION;

        Helper::mapOntoInstance(['config' => $configInfo], $this->asteriskInfo);

        $this->assertInstanceOf(ConfigInfo::class, $this->asteriskInfo->getConfig());
    }

    public function testSetAndGetBuildInfo(): void
    {
        $buildInfo = BuildInfoTest::RAW_ARRAY_REPRESENTATION;

        Helper::mapOntoInstance(['build' => $buildInfo], $this->asteriskInfo);

        $this->assertInstanceOf(BuildInfo::class, $this->asteriskInfo->getBuild());
    }

    public function testSetAndGetSystemInfo(): void
    {
        $systemInfo = SystemInfoTest::RAW_ARRAY_REPRESENTATION;

        Helper::mapOntoInstance(['system' => $systemInfo], $this->asteriskInfo);

        $this->assertInstanceOf(SystemInfo::class, $this->asteriskInfo->getSystem());
    }
}
