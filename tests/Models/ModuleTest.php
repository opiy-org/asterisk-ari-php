<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models;

use JsonMapper_Exception;
use NgVoice\AriClient\Models\Module;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class ModuleTest
 *
 * @package NgVoice\AriClient\Tests\Models
 */
final class ModuleTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var Module $module
         */
        $module = Helper::mapAriResponseParametersToAriObject(
            'Module',
            [
                'name' => 'ExampleName',
                'use_count' => '5',
                'support_level' => 'ExampleSupportLevel',
                'status' => 'running',
                'description' => 'Cool module!'
            ]
        );
        $this->assertSame('ExampleName', $module->getName());
        $this->assertSame('running', $module->getStatus());
        $this->assertSame('Cool module!', $module->getDescription());
        $this->assertSame('ExampleSupportLevel', $module->getSupportLevel());
        $this->assertSame(5, $module->getUseCount());
    }
}
