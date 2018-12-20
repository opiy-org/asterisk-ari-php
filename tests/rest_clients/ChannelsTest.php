<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\rest_clients;


use AriStasisApp\models\CallerID;
use AriStasisApp\models\Channel;
use AriStasisApp\models\DialplanCEP;
use AriStasisApp\rest_clients\Channels;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ApplicationsTest
 *
 * @package AriStasisApp\Tests\http_client
 */
final class ChannelsTest extends TestCase
{
    public function applicationsInstanceProvider()
    {
        $settings = Yaml::parseFile(__DIR__ . '/../../environment.yaml');
        return [
            'setup applications' =>
                [new Channels($settings['tests']['asteriskUser'], $settings['tests']['asteriskPassword'])]
        ];
    }

    /**
     * @dataProvider applicationsInstanceProvider
     * @param Channels $channelsClient
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testInstanceMappable(Channels $channelsClient): void
    {
        $channelsList = $channelsClient->list();
        $this->assertInstanceOf(Channel::class, $channelsList[0]);
        $this->assertInstanceOf(CallerID::class, $channelsList[0]->getCaller());
        $this->assertInstanceOf(CallerID::class, $channelsList[0]->getConnected());
        $this->assertInstanceOf(DialplanCEP::class, $channelsList[0]->getDialplan());
    }

    /**
     * @dataProvider applicationsInstanceProvider
     * @param Channels $channelsClient
     */
    public function test(Channels $channelsClient): void
    {
        //$channelsClient->create('sip/alice', 'ExampleLocalApp');
    }
}