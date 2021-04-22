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
use OpiyOrg\AriClient\Model\Message\Event\BridgeDestroyed;
use OpiyOrg\AriClient\Tests\Helper;
use OpiyOrg\AriClient\Tests\Model\BridgeTest;
use PHPUnit\Framework\TestCase;

/**
 * Class BridgeDestroyedTest
 *
 * @package OpiyOrg\AriClient\Tests\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class BridgeDestroyedTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var BridgeDestroyed $bridgeDestroyed
         */
        $bridgeDestroyed = Helper::mapOntoAriEvent(
            BridgeDestroyed::class,
            [
                'bridge' => BridgeTest::RAW_ARRAY_REPRESENTATION,
            ]
        );
        $this->assertInstanceOf(Bridge::class, $bridgeDestroyed->getBridge());
    }
}
