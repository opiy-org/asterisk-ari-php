<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\rest_clients;


use AriStasisApp\rest_clients\Events;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;

/**
 * Class EventsTest
 *
 * @package AriStasisApp\Tests\http_client
 */
final class EventsTest extends TestCase
{
    public function eventsInstanceProvider()
    {
        $settings = Yaml::parseFile(__DIR__ . '/../../environment.yaml');
        return [
            'setup events' =>
                [new Events($settings['tests']['asteriskUser'], $settings['tests']['asteriskPassword'])]
        ];
    }

    /**
     * @dataProvider eventsInstanceProvider
     * @param Events $eventsClient
     *
     * @expectedException \GuzzleHttp\Exception\GuzzleException
     * @expectedExceptionCode 404
     * @expectedExceptionMessage Application not found
     */
    public function testCreateChannelUserevent(Events $eventsClient): void
    {
        $eventsClient->userEvent(
            'customUserEvent',
            'ExampleLocalApp',
            ['channel' => 'xxxxxx', 'endpoint' => 'sip/alice'],
            ["bla" => 'okay', 'ng' => 'voice']);
    }
}