<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Models\{DeviceState, Message\DeviceStateChanged};
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class DeviceStateChangedTest
 *
 * @package NgVoice\AriClient\Tests\Models\Message
 */
final class DeviceStateChangedTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var DeviceStateChanged $deviceStateChanged
         */
        $deviceStateChanged = Helper::mapMessageParametersToAriObject(
            'DeviceStateChanged',
            [
                'device_state' => [
                    'state' => 'BUSY',
                    'name' => 'ExampleName',
                ]
            ]
        );
        $this->assertInstanceOf(DeviceState::class, $deviceStateChanged->getDeviceState());
    }
}
