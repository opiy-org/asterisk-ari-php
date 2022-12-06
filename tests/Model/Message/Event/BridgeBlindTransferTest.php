<?php

/**
 * @copyright 2020 ng-voice GmbH
 *
 * @noinspection UnknownInspectionInspection The [EA] plugin for PhpStorm doesn't know
 * about the noinspection annotation.
 * @noinspection ClassMockingCorrectnessInspection We are using a dependency to hook
 * onto classes before the tests in order to remove the 'final' class keyword. This makes
 * the classes extendable for PhpUnit and therefore testable.
 */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model\Message\Event;

use OpiyOrg\AriClient\Model\{Bridge, Channel};
use OpiyOrg\AriClient\Model\Message\Event\BridgeBlindTransfer;
use OpiyOrg\AriClient\Tests\Helper;
use OpiyOrg\AriClient\Tests\Model\BridgeTest;
use OpiyOrg\AriClient\Tests\Model\ChannelTest;
use PHPUnit\Framework\TestCase;

/**
 * Class BridgeBlindTransferTest
 *
 * @package OpiyOrg\AriClient\Tests\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class BridgeBlindTransferTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var BridgeBlindTransfer $bridgeBlindTransfer
         */
        $bridgeBlindTransfer = Helper::mapOntoAriEvent(
            BridgeBlindTransfer::class,
            [
                'bridge' => BridgeTest::RAW_ARRAY_REPRESENTATION,
                'replace_channel' => ChannelTest::RAW_ARRAY_REPRESENTATION,
                'is_external' => true,
                'exten' => 'ExampleExten',
                'result' => 'Result',
                'context' => 'ExampleContext',
                'transferee' => ChannelTest::RAW_ARRAY_REPRESENTATION,
                'channel' => ChannelTest::RAW_ARRAY_REPRESENTATION,
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
