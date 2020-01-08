<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model\Message\Event;

use NgVoice\AriClient\Model\DeviceState;
use NgVoice\AriClient\Model\Message\Event\DeviceStateChanged;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class DeviceStateChangedTest
 *
 * @package NgVoice\AriClient\Tests\Model\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class DeviceStateChangedTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var DeviceStateChanged $deviceStateChanged
         */
        $deviceStateChanged = Helper::mapOntoAriEvent(
            DeviceStateChanged::class,
            [
                'device_state' => [
                    'state' => 'BUSY',
                    'name'  => 'ExampleName',
                ],
            ]
        );
        $this->assertInstanceOf(
            DeviceState::class,
            $deviceStateChanged->getDeviceState()
        );
    }
}
