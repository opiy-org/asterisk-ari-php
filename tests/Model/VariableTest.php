<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Model\Variable;
use PHPUnit\Framework\TestCase;
use function NgVoice\AriClient\Tests\mapAriResponseParametersToAriObject;

/**
 * Class VariableTest
 *
 * @package NgVoice\AriClient\Tests\Model
 */
final class VariableTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
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