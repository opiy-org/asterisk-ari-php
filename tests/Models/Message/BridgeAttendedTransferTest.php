<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models\Message;

use JsonMapper_Exception;
use NgVoice\AriClient\Models\{Bridge, Channel, Message\BridgeAttendedTransfer};
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class BridgeAttendedTransferTest
 *
 * @package NgVoice\AriClient\Tests\Models\Message
 */
final class BridgeAttendedTransferTest extends TestCase
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
         * @var BridgeAttendedTransfer $bridgeAttendedTransfer
         */
        $bridgeAttendedTransfer = Helper::mapMessageParametersToAriObject(
            'BridgeAttendedTransfer',
            [
                'replace_channel' => $exampleChannel,
                'is_external' => true,
                'transferer_second_leg_bridge' => $exampleBridge,
                'destination_bridge' => 'DestinationBridge',
                'transferer_second_leg' => $exampleChannel,
                'destination_link_second_leg' => $exampleChannel,
                'destination_threeway_channel' => $exampleChannel,
                'transfer_target' => $exampleChannel,
                'result' => 'Result',
                'destination_type' => 'DestinationType',
                'destination_application' => 'MyExampleStasisApp',
                'destination_threeway_bridge' => $exampleBridge,
                'destination_link_first_leg' => $exampleChannel,
                'transferee' => $exampleChannel,
                'transferer_first_leg' => $exampleChannel,
                'transferer_first_leg_bridge' => $exampleBridge
            ]
        );
        $this->assertInstanceOf(Channel::class, $bridgeAttendedTransfer->getReplaceChannel());
        $this->assertSame(true, $bridgeAttendedTransfer->isExternal());
        $this->assertInstanceOf(Bridge::class, $bridgeAttendedTransfer->getTransfererSecondLegBridge());
        $this->assertSame('DestinationBridge', $bridgeAttendedTransfer->getDestinationBridge());
        $this->assertInstanceOf(Channel::class, $bridgeAttendedTransfer->getTransfererSecondLeg());
        $this->assertInstanceOf(Channel::class, $bridgeAttendedTransfer->getDestinationLinkSecondLeg());
        $this->assertInstanceOf(Channel::class, $bridgeAttendedTransfer->getDestinationThreewayChannel());
        $this->assertInstanceOf(Channel::class, $bridgeAttendedTransfer->getTransferTarget());
        $this->assertSame('Result', $bridgeAttendedTransfer->getResult());
        $this->assertSame('DestinationType', $bridgeAttendedTransfer->getDestinationType());
        $this->assertSame('MyExampleStasisApp', $bridgeAttendedTransfer->getDestinationApplication());
        $this->assertInstanceOf(Bridge::class, $bridgeAttendedTransfer->getDestinationThreewayBridge());
        $this->assertInstanceOf(Channel::class, $bridgeAttendedTransfer->getDestinationLinkFirstLeg());
        $this->assertInstanceOf(Channel::class, $bridgeAttendedTransfer->getTransferee());
        $this->assertInstanceOf(Channel::class, $bridgeAttendedTransfer->getTransfererFirstLeg());
        $this->assertInstanceOf(Bridge::class, $bridgeAttendedTransfer->getTransfererFirstLegBridge());
    }
}
