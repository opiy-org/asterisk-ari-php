<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models;


use JsonMapper_Exception;
use NgVoice\AriClient\Models\{ConfigTuple};
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class ConfigTupleTest
 *
 * @package NgVoice\AriClient\Tests\Models
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
        $configTuple = Helper::mapAriResponseParametersToAriObject(
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
