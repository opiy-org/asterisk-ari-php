<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\models;


require_once __DIR__ . '/../../shared_test_functions.php';

use AriStasisApp\models\{DeviceState, messages\DeviceStateChanged};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapMessageParametersToAriObject;

/**
 * Class DeviceStateChangedTest
 *
 * @package AriStasisApp\Tests\models\messages
 */
final class DeviceStateChangedTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
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