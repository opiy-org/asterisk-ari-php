<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Model\{ConfigTuple};
use PHPUnit\Framework\TestCase;
use function NgVoice\AriClient\Tests\mapAriResponseParametersToAriObject;

/**
 * Class ConfigTupleTest
 *
 * @package NgVoice\AriClient\Tests\Model
 */
final class ConfigTupleTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
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