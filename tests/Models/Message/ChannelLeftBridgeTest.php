<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models\Message;


use JsonMapper_Exception;
use NgVoice\AriClient\Models\{Bridge, Channel, Message\ChannelLeftBridge};
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class ChannelLeftBridgeTest
 *
 * @package NgVoice\AriClient\Tests\Models\Message
 */
final class ChannelLeftBridgeTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
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
         * @var ChannelLeftBridge $channelLeftBridge
         */
        $channelLeftBridge = Helper::mapMessageParametersToAriObject(
            'ChannelLeftBridge',
            [
                'bridge' => $exampleBridge,
                'channel' => $exampleChannel
            ]
        );
        $this->assertInstanceOf(Bridge::class, $channelLeftBridge->getBridge());
        $this->assertInstanceOf(Channel::class, $channelLeftBridge->getChannel());
    }
}
