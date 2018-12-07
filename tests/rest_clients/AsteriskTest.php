<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\rest_clients;


use AriStasisApp\models\{AsteriskInfo, BuildInfo, ConfigInfo, StatusInfo, SystemInfo};
use AriStasisApp\rest_clients\Asterisk;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;

/**
 * Class AsteriskTest
 *
 * @package AriStasisApp\Tests\http_client
 */
final class AsteriskTest extends TestCase
{
    public function asteriskInstanceProvider()
    {
        $settings = Yaml::parseFile(__DIR__ . '/../../environment.yaml');
        return [
            'setup asterisk' =>
                [new Asterisk($settings['tests']['asteriskUser'], $settings['tests']['asteriskPassword'])]
        ];
    }

    /**
     * @dataProvider asteriskInstanceProvider
     *
     * @param Asterisk $asteriskClient
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetAsteriskInfo(Asterisk $asteriskClient): void
    {
        $asteriskInfo = $asteriskClient->getInfo();
        $this->assertInstanceOf(AsteriskInfo::class, $asteriskInfo);
        $this->assertInstanceOf(SystemInfo::class, $asteriskInfo->getSystem());
        $this->assertInstanceOf(BuildInfo::class, $asteriskInfo->getBuild());
        $this->assertInstanceOf(StatusInfo::class, $asteriskInfo->getStatus());
        $this->assertInstanceOf(ConfigInfo::class, $asteriskInfo->getConfig());
    }

    /**
     * @dataProvider asteriskInstanceProvider
     *
     * @param Asterisk $asteriskClient
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetAsteriskInfoOnly(Asterisk $asteriskClient): void
    {
        $asteriskInfo = $asteriskClient->getInfo(['build', 'config']);
        $this->assertInstanceOf(AsteriskInfo::class, $asteriskInfo);
        $this->assertAttributeInstanceOf(BuildInfo::class,'build', $asteriskInfo);
        $this->assertAttributeInstanceOf(ConfigInfo::class, 'config', $asteriskInfo);
        $this->assertAttributeEquals(null, 'system', $asteriskInfo);
        $this->assertAttributeEquals(null,'status', $asteriskInfo);
    }
}