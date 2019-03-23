<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Model\TextMessageVariable;
use PHPUnit\Framework\TestCase;
use function NgVoice\AriClient\Tests\mapAriResponseParametersToAriObject;

class TextMessageVariableTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var TextMessageVariable $textMessageVariable
         */
        $textMessageVariable = mapAriResponseParametersToAriObject(
            'TextMessageVariable',
            [
                'key' => 'SomeKey',
                'value' => 'SomeValue'
            ]
        );
        $this->assertSame('SomeKey', $textMessageVariable->getKey());
        $this->assertSame('SomeValue', $textMessageVariable->getValue());
    }
}
