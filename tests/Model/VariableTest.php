<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;

use NgVoice\AriClient\Model\Variable;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class VariableTest
 *
 * @package NgVoice\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class VariableTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        $variable = new Variable();

        Helper::mapOntoInstance(['value' => 'testValue'], $variable);

        $this->assertSame('testValue', $variable->getValue());
    }
}
