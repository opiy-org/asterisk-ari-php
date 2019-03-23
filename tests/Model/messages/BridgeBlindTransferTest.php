<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use NgVoice\AriClient\Model\{Bridge, Channel, Message\BridgeBlindTransfer};
use PHPUnit\Framework\TestCase;
use function NgVoice\AriClient\Tests\mapMessageParametersToAriObject;

/**
 * Class BridgeBlindTransferTest
 *
 * @package NgVoice\AriClient\Tests\Model\Message
 */
final class BridgeBlindTransferTest extends TestCase
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
         * @var BridgeBlindTransfer $bridgeBlindTransfer
         */
        $bridgeBlindTransfer = mapMessageParametersToAriObject(
            'BridgeBlindTransfer',
            [
                'bridge' => $exampleBridge,
                'replace_channel' => $exampleChannel,
                'is_external' => true,
                'exten' => 'ExampleExten',
                'result' => 'Result',
                'context' => 'ExampleContext',
                'transferee' => $exampleChannel,
                'channel' => $exampleChannel
            ]
        );
        $this->assertInstanceOf(Bridge::class, $bridgeBlindTransfer->getBridge());
        $this->assertInstanceOf(Channel::class, $bridgeBlindTransfer->getReplaceChannel());
        $this->assertSame(true, $bridgeBlindTransfer->isExternal());
        $this->assertSame('ExampleExten', $bridgeBlindTransfer->getExten());
        $this->assertSame('Result', $bridgeBlindTransfer->getResult());
        $this->assertSame('ExampleContext', $bridgeBlindTransfer->getContext());
        $this->assertInstanceOf(Channel::class, $bridgeBlindTransfer->getTransferee());
        $this->assertInstanceOf(Channel::class, $bridgeBlindTransfer->getChannel());
    }
}