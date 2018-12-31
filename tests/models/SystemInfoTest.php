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
use Symfony\Component\Yaml\Yaml;

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
        $settings = Yaml::parseFile(__DIR__ . '/../../environment.yaml');
        return [
            'setup asterisk' =>
                [(new Asterisk($settings['tests']['asteriskUser'], $settings['tests']['asteriskPassword']))->getInfo()]
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