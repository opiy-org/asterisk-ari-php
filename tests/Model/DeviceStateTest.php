<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Model\{DeviceState};
use PHPUnit\Framework\TestCase;
use function NgVoice\AriClient\Tests\mapAriResponseParametersToAriObject;

/**
 * Class DeviceStateTest
 *
 * @package NgVoice\AriClient\Tests\Model
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