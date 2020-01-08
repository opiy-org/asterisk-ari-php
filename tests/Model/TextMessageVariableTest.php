<?php

/** @copyright 2020 ng-voice GmbH */

namespace NgVoice\AriClient\Tests\Model;

use NgVoice\AriClient\Model\TextMessageVariable;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class TextMessageVariableTest
 *
 * @package NgVoice\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class TextMessageVariableTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var TextMessageVariable $textMessageVariable
         */
        $textMessageVariable = Helper::mapOntoInstance(
            [
                'key'   => 'SomeKey',
                'value' => 'SomeValue',
            ],
            new TextMessageVariable()
        );
        $this->assertSame('SomeKey', $textMessageVariable->getKey());
        $this->assertSame('SomeValue', $textMessageVariable->getValue());
    }
}
