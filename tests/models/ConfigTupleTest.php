<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\models;


require_once __DIR__ . '/../shared_test_functions.php';

use AriStasisApp\models\{ConfigTuple};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapAriResponseParametersToAriObject;

/**
 * Class ConfigTupleTest
 *
 * @package AriStasisApp\Tests\models
 */
final class ConfigTupleTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var ConfigTuple $configTuple
         */
        $configTuple = mapAriResponseParametersToAriObject(
            'ConfigTuple',
            [
                'attribute' => 'ExampleAttribute',
                'value' => 'ExampleValue'
            ]
        );
        $this->assertSame('ExampleValue', $configTuple->getValue());
        $this->assertSame('ExampleAttribute', $configTuple->getAttribute());
    }
}