<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;

use JsonMapper_Exception;
use NgVoice\AriClient\Models\{Channel, Message\ChannelTalkingFinished};
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class ChannelTalkingFinishedTest
 *
 * @package NgVoice\AriClient\Tests\Models\Message
 */
final class ChannelTalkingFinishedTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
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
         * @var ChannelTalkingFinished $channelTalkingFinished
         */
        $channelTalkingFinished = Helper::mapMessageParametersToAriObject(
            'ChannelTalkingFinished',
            [
                'channel' => $exampleChannel,
                'duration' => 44
            ]
        );
        $this->assertInstanceOf(Channel::class, $channelTalkingFinished->getChannel());
        $this->assertSame(44, $channelTalkingFinished->getDuration());
    }
}
