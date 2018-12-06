<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\models;


use AriStasisApp\models\AsteriskInfo;
use AriStasisApp\models\SystemInfo;
use AriStasisApp\rest_clients\Asterisk;
use PHPUnit\Framework\TestCase;

/**
 * Class SystemInfoTest
 *
 * @package AriStasisApp\Tests\http_client
 */
final class SystemInfoTest extends TestCase
{
    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function asteriskInstanceProvider()
    {
        return [
            'setup asterisk info' => [(new Asterisk('asterisk', 'asterisk'))->getInfo(['system'])]
        ];
    }

    /**
     * @dataProvider asteriskInstanceProvider
     *
     * @param AsteriskInfo $asteriskInfo
     */
    public function testSystemInfoGetter(AsteriskInfo $asteriskInfo): void
    {
        $systemInfo = $asteriskInfo->getSystem();
        $this->assertInstanceOf(SystemInfo::class, $systemInfo);

    }
}