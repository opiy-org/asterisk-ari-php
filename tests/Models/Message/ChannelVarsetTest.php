<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models\Message;

use JsonMapper_Exception;
use NgVoice\AriClient\Models\{Channel, Message\ChannelVarset};
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class ChannelVarsetTest
 *
 * @package NgVoice\AriClient\Tests\Models\Message
 */
final class ChannelVarsetTest extends TestCase
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
         * @var ChannelVarset $channelVarSet
         */
        $channelVarSet = Helper::mapMessageParametersToAriObject(
            'ChannelVarset',
            [
                'variable' => 'TestVar',
                'value' => 'TestValue',
                'channel' => $exampleChannel
            ]
        );
        $this->assertInstanceOf(Channel::class, $channelVarSet->getChannel());
        $this->assertSame('TestVar', $channelVarSet->getVariable());
        $this->assertSame('TestValue', $channelVarSet->getValue());
    }
}
