<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model;

use OpiyOrg\AriClient\Model\{DeviceState};
use OpiyOrg\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class DeviceStateTest
 *
 * @package OpiyOrg\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class DeviceStateTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var DeviceState $deviceState
         */
        $deviceState = Helper::mapOntoInstance(
            [
                'state' => 'BUSY',
                'name'  => 'ExampleName',
            ],
            new DeviceState()
        );
        $this->assertSame('BUSY', $deviceState->getState());
        $this->assertSame('ExampleName', $deviceState->getName());
    }
}
