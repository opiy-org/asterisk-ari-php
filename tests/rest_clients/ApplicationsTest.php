<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\rest_clients;


use AriStasisApp\models\Application;
use AriStasisApp\rest_clients\Applications;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ApplicationsTest
 *
 * @package AriStasisApp\Tests\http_client
 */
final class ApplicationsTest extends TestCase
{
    public function applicationsInstanceProvider()
    {
        $settings = Yaml::parseFile(__DIR__ . '/../../environment.yaml');
        return [
            'setup applications' =>
                [new Applications($settings['tests']['asteriskUser'], $settings['tests']['asteriskPassword'])]
        ];
    }

    /**
     * @dataProvider applicationsInstanceProvider
     * @param Applications $applicationsClient
     * @expectedException \GuzzleHttp\Exception\GuzzleException
     * @expectedExceptionCode 404
     */
    public function testNameNotFoundThrowsException(Applications $applicationsClient): void
    {
        $applicationsClient->get('xxxxxxxxx');
    }

    /**
     * @dataProvider applicationsInstanceProvider
     * @param Applications $applicationsClient
     */
    public function testListAllSounds(Applications $applicationsClient): void
    {
        $mockApplication = $this->getMockBuilder(Application::class)->getMock();
        $mockApplication->method('getEndpointIds')->willReturn(['123', '456']);

        //$applicationsList = $applicationsClient->list();
        $applicationsList = [$mockApplication];
        $this->assertInstanceOf(Application::class, $applicationsList[0]);
        //$this->assertInstanceOf(FormatLangPair::class, $applicationsList[0]->getEndpointIds()[0]);
    }
}