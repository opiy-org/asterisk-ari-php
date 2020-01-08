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

namespace NgVoice\AriClient\Tests\Model\Message\Event;

use NgVoice\AriClient\Model\Bridge;
use NgVoice\AriClient\Model\Message\Event\BridgeVideoSourceChanged;
use NgVoice\AriClient\Tests\Helper;
use NgVoice\AriClient\Tests\Model\BridgeTest;
use PHPUnit\Framework\TestCase;

/**
 * Class BridgeVideoSourceChangedTest
 *
 * @package NgVoice\AriClient\Tests\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class BridgeVideoSourceChangedTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var BridgeVideoSourceChanged $bridgeVideoSourceChanged
         */
        $bridgeVideoSourceChanged = Helper::mapOntoAriEvent(
            BridgeVideoSourceChanged::class,
            [
                'bridge'              => BridgeTest::RAW_ARRAY_REPRESENTATION,
                'old_video_source_id' => '15g5',
            ]
        );
        $this->assertInstanceOf(Bridge::class, $bridgeVideoSourceChanged->getBridge());
        $this->assertSame('15g5', $bridgeVideoSourceChanged->getOldVideoSourceId());
    }
}
