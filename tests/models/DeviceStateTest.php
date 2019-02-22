<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\models;


require_once __DIR__ . '/../shared_test_functions.php';

use AriStasisApp\models\{DeviceState};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapAriResponseParametersToAriObject;

/**
 * Class DeviceStateTest
 *
 * @package AriStasisApp\Tests\models
 */
final class DeviceStateTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var DeviceState $deviceState
         */
        $deviceState = mapAriResponseParametersToAriObject(
            'DeviceState',
            [
                'state' => 'BUSY',
                'name' => 'ExampleName',
            ]
        );
        $this->assertSame('BUSY', $deviceState->getState());
        $this->assertSame('ExampleName', $deviceState->getName());
    }
}