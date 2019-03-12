<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\Model;


require_once __DIR__ . '/../../shared_test_functions.php';

use AriStasisApp\Model\{Bridge, Channel, Endpoint, Message\ChannelUserevent};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapMessageParametersToAriObject;

/**
 * Class ChannelUsereventTest
 *
 * @package AriStasisApp\Tests\Model\Message
 */
final class ChannelUsereventTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        $exampleBridge = [
            'bridge_class' => 'ExampleClass',
            'bridge_type' => 'mixing',
            'channels' => [],
            'creator' => 'ExampleCreator',
            'id' => 'id1',
            'name' => 'ExampleName',
            'technology' => 'ExampleTechnology',
            'video_mode' => 'none',
            'video_source_id' => 'VideoId'
        ];

        $exampleChannel = [
            'name' => 'SIP/foo-0000a7e3',
            'language' => 'en',
            'accountcode' => 'TestAccount',
            'channelvars' => [
                'testVar' => 'correct',
                'testVar2' => 'nope'
            ],
            'caller' => [
                'name' => 'ExampleName',
                'number' => 'ExampleNumber'
            ],
            'creationtime' => '2016-12-20 13:45:28 UTC',
            'state' => 'Up',
            'connected' => [
                'name' => 'ExampleName2',
                'number' => 'ExampleNumber2'
            ],
            'dialplan' => [
                'context' => 'ExampleContext',
                'exten' => 'ExampleExten',
                'priority' => '3'
            ],
            'id' => '123456'
        ];

        /**
         * @var ChannelUserevent $channelUserEvent
         */
        $channelUserEvent = mapMessageParametersToAriObject(
            'ChannelUserevent',
            [
                'eventname' => 'ExampleEvent',
                'bridge' => $exampleBridge,
                'userevent' => [
                    'someEvent' => 'someValue'
                ],
                'endpoint' => [
                    'state' => 'online',
                    'technology' => 'ExampleTechnology',
                    'channel_ids' => [],
                    'resource' => 'ExampleResource'
                ],
                'channel' => $exampleChannel
            ]
        );
        $this->assertSame('ExampleEvent', $channelUserEvent->getEventname());
        $this->assertInstanceOf(Bridge::class, $channelUserEvent->getBridge());
        $this->assertIsObject($channelUserEvent->getUserevent());
        $this->assertObjectHasAttribute('someEvent', $channelUserEvent->getUserevent());
        $this->assertSame('someValue', $channelUserEvent->getUserevent()->someEvent);
        $this->assertInstanceOf(Endpoint::class, $channelUserEvent->getEndpoint());
        $this->assertInstanceOf(Channel::class, $channelUserEvent->getChannel());
    }
}