<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model;

use OpiyOrg\AriClient\Model\Variable;
use OpiyOrg\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class VariableTest
 *
 * @package OpiyOrg\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class VariableTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        $variable = new Variable();

        $variable = Helper::mapOntoInstance(['value' => 'testValue'], $variable);

        $this->assertSame('testValue', $variable->getValue());
    }
}
