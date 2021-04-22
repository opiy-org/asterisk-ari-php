<?php

/**
 * @copyright 2020 ng-voice GmbH
 *
 * @noinspection UnknownInspectionInspection The [EA] plugin for PhpStorm doesn't know
 * about the noinspection annotation.
 * @noinspection UnnecessaryAssertionInspection Some sort of test is needed!
 */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model\Message\Event;

use OpiyOrg\AriClient\Model\Bridge;
use OpiyOrg\AriClient\Model\Channel;
use OpiyOrg\AriClient\Model\Message\Event\BridgeAttendedTransfer;
use OpiyOrg\AriClient\Tests\Helper;
use OpiyOrg\AriClient\Tests\Model\{BridgeTest, ChannelTest};
use PHPUnit\Framework\TestCase;

/**
 * Class BridgeAttendedTransferTest
 *
 * @package OpiyOrg\AriClient\Tests\Model\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class BridgeAttendedTransferTest extends TestCase
{
    public function testGetter(): void
    {
        /** @var BridgeAttendedTransfer $bridgeAttendedTransfer */
        $bridgeAttendedTransfer = Helper::mapOntoAriEvent(
            BridgeAttendedTransfer::class,
            [
                'destination_application'      => 'someDestinationApplication',
                'destination_bridge'           => 'someDestinationBridge',
                'destination_link_first_leg'   => ChannelTest::RAW_ARRAY_REPRESENTATION,
                'destination_link_second_leg'  => ChannelTest::RAW_ARRAY_REPRESENTATION,
                'destination_threeway_bridge'  => BridgeTest::RAW_ARRAY_REPRESENTATION,
                'destination_threeway_channel' => ChannelTest::RAW_ARRAY_REPRESENTATION,
                'destination_type'             => 'someDestinationType',
                'is_external'                  => true,
                'replace_channel'              => ChannelTest::RAW_ARRAY_REPRESENTATION,
                'result'                       => 'someResult',
                'transfer_target'              => ChannelTest::RAW_ARRAY_REPRESENTATION,
                'transferee'                   => ChannelTest::RAW_ARRAY_REPRESENTATION,
                'transferer_first_leg'         => ChannelTest::RAW_ARRAY_REPRESENTATION,
                'transferer_first_leg_bridge'  => BridgeTest::RAW_ARRAY_REPRESENTATION,
                'transferer_second_leg'        => ChannelTest::RAW_ARRAY_REPRESENTATION,
                'transferer_second_leg_bridge' => BridgeTest::RAW_ARRAY_REPRESENTATION,
            ]
        );

        $this->assertSame(
            'someDestinationApplication',
            $bridgeAttendedTransfer->getDestinationApplication()
        );

        $this->assertInstanceOf(
            Channel::class,
            $bridgeAttendedTransfer->getTransfererFirstLeg()
        );

        $this->assertSame(
            'someDestinationBridge',
            $bridgeAttendedTransfer->getDestinationBridge()
        );

        $this->assertSame(
            'someDestinationType',
            $bridgeAttendedTransfer->getDestinationType()
        );

        $this->assertSame(
            'someResult',
            $bridgeAttendedTransfer->getResult()
        );

        $this->assertTrue($bridgeAttendedTransfer->isExternal());

        $this->assertInstanceOf(
            Bridge::class,
            $bridgeAttendedTransfer->getDestinationThreewayBridge()
        );

        $this->assertInstanceOf(
            Bridge::class,
            $bridgeAttendedTransfer->getTransfererFirstLegBridge()
        );

        $this->assertInstanceOf(
            Bridge::class,
            $bridgeAttendedTransfer->getTransfererSecondLegBridge()
        );

        $this->assertInstanceOf(
            Channel::class,
            $bridgeAttendedTransfer->getTransferee()
        );

        $this->assertInstanceOf(
            Channel::class,
            $bridgeAttendedTransfer->getTransferTarget()
        );

        $this->assertInstanceOf(
            Channel::class,
            $bridgeAttendedTransfer->getDestinationThreewayChannel()
        );

        $this->assertInstanceOf(
            Channel::class,
            $bridgeAttendedTransfer->getDestinationLinkSecondLeg()
        );

        $this->assertInstanceOf(
            Channel::class,
            $bridgeAttendedTransfer->getDestinationLinkFirstLeg()
        );

        $this->assertInstanceOf(
            Channel::class,
            $bridgeAttendedTransfer->getReplaceChannel()
        );

        $this->assertInstanceOf(
            Channel::class,
            $bridgeAttendedTransfer->getTransfererSecondLeg()
        );
    }
}
