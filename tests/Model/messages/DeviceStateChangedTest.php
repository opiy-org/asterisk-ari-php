<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Model\{DeviceState, Message\DeviceStateChanged};
use PHPUnit\Framework\TestCase;
use function NgVoice\AriClient\Tests\mapMessageParametersToAriObject;

/**
 * Class DeviceStateChangedTest
 *
 * @package NgVoice\AriClient\Tests\Model\Message
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
        $deviceStateChanged = mapMessageParametersToAriObject(
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