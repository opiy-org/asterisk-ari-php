<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\Model;


require_once __DIR__ . '/../shared_test_functions.php';

use AriStasisApp\Model\{Module};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapAriResponseParametersToAriObject;

/**
 * Class ModuleTest
 *
 * @package AriStasisApp\Tests\Model
 */
final class ModuleTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var Module $module
         */
        $module = mapAriResponseParametersToAriObject(
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