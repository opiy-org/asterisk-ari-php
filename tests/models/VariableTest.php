<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\models;


require_once __DIR__ . '/../shared_test_functions.php';

use AriStasisApp\models\Variable;
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapAriResponseParametersToAriObject;

/**
 * Class VariableTest
 *
 * @package AriStasisApp\Tests\models
 */
final class VariableTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var Variable $variable
         */
        $variable = mapAriResponseParametersToAriObject(
            'Variable',
            [
                'value' => 'testValue'
            ]
        );
        $this->assertSame('testValue', $variable->getValue());
    }
}