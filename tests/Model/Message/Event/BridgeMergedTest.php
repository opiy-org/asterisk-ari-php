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

use OpiyOrg\AriClient\Model\Bridge;
use OpiyOrg\AriClient\Model\Message\Event\BridgeMerged;
use OpiyOrg\AriClient\Tests\Helper;
use OpiyOrg\AriClient\Tests\Model\BridgeTest;
use PHPUnit\Framework\TestCase;

/**
 * Class BridgeMergedTest
 *
 * @package OpiyOrg\AriClient\Tests\Model\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class BridgeMergedTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var BridgeMerged $bridgeMerged
         */
        $bridgeMerged = Helper::mapOntoAriEvent(
            BridgeMerged::class,
            [
                'bridge' => BridgeTest::RAW_ARRAY_REPRESENTATION,
                'bridge_from' => BridgeTest::RAW_ARRAY_REPRESENTATION,
            ]
        );
        $this->assertInstanceOf(Bridge::class, $bridgeMerged->getBridge());
        $this->assertInstanceOf(Bridge::class, $bridgeMerged->getBridgeFrom());
    }
}
