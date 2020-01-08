<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;

use NgVoice\AriClient\Model\Module;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class ModuleTest
 *
 * @package NgVoice\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ModuleTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var Module $module
         */
        $module = Helper::mapOntoInstance(
            [
                'name'          => 'ExampleName',
                'use_count'     => 5,
                'support_level' => 'ExampleSupportLevel',
                'status'        => 'running',
                'description'   => 'Cool module!',
            ],
            new Module()
        );
        $this->assertSame('ExampleName', $module->getName());
        $this->assertSame('running', $module->getStatus());
        $this->assertSame('Cool module!', $module->getDescription());
        $this->assertSame('ExampleSupportLevel', $module->getSupportLevel());
        $this->assertSame(5, $module->getUseCount());
    }
}
