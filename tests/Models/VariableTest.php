<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models;

use JsonMapper_Exception;
use NgVoice\AriClient\Models\Variable;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class VariableTest
 *
 * @package NgVoice\AriClient\Tests\Models
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
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
        $variable = Helper::mapAriResponseParametersToAriObject(
            'Variable',
            [
                'value' => 'testValue'
            ]
        );
        $this->assertSame('testValue', $variable->getValue());
    }
}
