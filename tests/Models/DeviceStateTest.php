<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models;

use JsonMapper_Exception;
use NgVoice\AriClient\Models\{DeviceState};
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class DeviceStateTest
 *
 * @package NgVoice\AriClient\Tests\Models
 */
final class DeviceStateTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var DeviceState $deviceState
         */
        $deviceState = Helper::mapAriResponseParametersToAriObject(
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
