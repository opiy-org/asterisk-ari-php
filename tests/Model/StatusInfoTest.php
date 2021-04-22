<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model;

use OpiyOrg\AriClient\Model\StatusInfo;
use OpiyOrg\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class StatusInfoTest
 *
 * @package OpiyOrg\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class StatusInfoTest extends TestCase
{
    public const RAW_ARRAY_REPRESENTATION = [
        'startup_time'     => '2019-02-19T22:43:31.820+0000',
        'last_reload_time' => '2019-02-19T22:43:31.820+0000',
    ];

    public function testParametersMappedCorrectly(): void
    {
        $statusInfo = new StatusInfo();
        Helper::mapOntoInstance(self::RAW_ARRAY_REPRESENTATION, $statusInfo);

        $this->assertSame(
            '2019-02-19T22:43:31.820+0000',
            $statusInfo->getStartupTime()
        );
        $this->assertSame(
            '2019-02-19T22:43:31.820+0000',
            $statusInfo->getLastReloadTime()
        );
    }
}
