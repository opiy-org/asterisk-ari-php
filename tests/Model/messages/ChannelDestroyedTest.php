<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace AriClient\Tests\Model;

use JsonMapper_Exception;
use NgVoice\AriClient\Models\{Channel, Message\ChannelDestroyed};
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class ChannelDestroyedTest
 *
 * @package NgVoice\AriClient\Tests\Models\Message
 */
final class ChannelDestroyedTest extends TestCase
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
         * @var ChannelDestroyed $channelDestroyed
         */
        $channelDestroyed = Helper::mapMessageParametersToAriObject(
            'ChannelDestroyed',
            [
                'cause' => '23',
                'cause_txt' => 'SomeCauseTxt',
                'channel' => $exampleChannel
            ]
        );
        $this->assertInstanceOf(Channel::class, $channelDestroyed->getChannel());
        $this->assertSame(23, $channelDestroyed->getCause());
        $this->assertSame('SomeCauseTxt', $channelDestroyed->getCauseTxt());
    }
}
