<?php

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model;

use OpiyOrg\AriClient\Model\TextMessageVariable;
use OpiyOrg\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class TextMessageVariableTest
 *
 * @package OpiyOrg\AriClient\Tests\Model
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
                'key' => 'SomeKey',
                'value' => 'SomeValue',
            ],
            new TextMessageVariable()
        );
        $this->assertSame('SomeKey', $textMessageVariable->getKey());
        $this->assertSame('SomeValue', $textMessageVariable->getValue());
    }
}
