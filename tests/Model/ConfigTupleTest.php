<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model;

use OpiyOrg\AriClient\Model\{ConfigTuple};
use OpiyOrg\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class ConfigTupleTest
 *
 * @package OpiyOrg\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ConfigTupleTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var ConfigTuple $configTuple
         */
        $configTuple = Helper::mapOntoInstance(
            [
                'attribute' => 'ExampleAttribute',
                'value'     => 'ExampleValue',
            ],
            new ConfigTuple()
        );
        $this->assertSame('ExampleValue', $configTuple->getValue());
        $this->assertSame('ExampleAttribute', $configTuple->getAttribute());
    }
}
