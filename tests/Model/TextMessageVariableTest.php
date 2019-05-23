<?php

/** @copyright 2019 ng-voice GmbH */

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Models\TextMessageVariable;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

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
        $textMessageVariable = Helper::mapAriResponseParametersToAriObject(
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
